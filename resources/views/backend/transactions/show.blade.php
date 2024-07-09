@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs>
    <x-backend.breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend.breadcrumb-item>
    <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
</x-backend.breadcrumbs>
@endsection

@section('content')

<x-backend.layouts.show :data="$$module_name_singular" :module_name="$module_name" :module_path="$module_path" :module_title="$module_title" :module_icon="$module_icon" :module_action="$module_action">
    <div class="card">
        <div class="card-body">
            <x-backend.section-header :data="$$module_name_singular" :module_name="$module_name" :module_title="$module_title" :module_icon="$module_icon" :module_action="$module_action" />
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="card-title">{{ $transaction->invoice }}</h5>
                    <p class="card-text">
                        <strong>Name:</strong> {{ $transaction->name }}<br>
                        <strong>Number:</strong> {{ $transaction->number }}<br>
                        <strong>Status:</strong> {{ $transaction->status }}<br>
                        <strong>Jenis:</strong> {{ $transaction->is_inplace ? "dine-in" : "takeaway" }}<br>
                    </p>

                    <h6 class="mt-4">Rewards</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Makanan</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction->transaction_details as $detail)
                            <tr>
                                <td>{{ $detail->food->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ $detail->total_price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <label for="tax">Tax (%)</label>
                        <input type="number" id="tax" name="tax" class="form-control mb-2" placeholder="Enter tax amount">

                        <label for="discount">Discount (Rp.)</label>
                        <input type="number" id="discount" name="discount" class="form-control mb-2" placeholder="Enter discount percentage">

                        <h6 class="mt-3">Grand Total</h6>
                        <input type="text" id="grand-total" class="form-control mb-2" readonly>

                        <label for="payment">Payment</label>
                        <input type="number" id="payment" name="payment" class="form-control mb-2" placeholder="Enter payment amount">

                        <label for="change">Change</label>
                        <input type="text" id="change" class="form-control mb-4" readonly>

                        <button id="save-transaction" class="btn btn-primary">Save Transaction</button>
                    </div>
                </div>
            </div>

            <!-- Modal for Summary -->
            <div class="modal fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="summaryModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="summaryModalLabel">Transaction Summary</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Summary details will be filled here via jQuery -->
                            <div id="transaction-summary-content" class="receipt"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="print-summary" class="btn btn-primary">Print Summary</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-backend.layouts.show>
@endsection

@push('after-scripts')
<style>
    .receipt-header {
        text-align: center;
        margin-bottom: 20px;
    }
    .receipt-header h4 {
        margin: 0;
        font-weight: bold;
    }
    .receipt-header p {
        margin: 0;
        font-size: 14px;
    }
    .receipt-info {
        margin-bottom: 20px;
    }
    .receipt-info p {
        margin: 0;
        font-size: 14px;
    }
    .table {
        width: 100%;
        margin-bottom: 20px;
    }
    .table th, .table td {
        padding: 8px;
        text-align: left;
    }
    .table th {
        background-color: #f8f8f8;
    }

    @media print {
        @page {
            size: A5;
            /* margin: 10mm; */
        }
        body * {
            visibility: hidden;
        }
        #summaryModal .modal-content, #summaryModal .modal-content * {
            visibility: visible;
        }
        #summaryModal {
            position: absolute;
            left: 0;
            top: -50;
            width: 100%;
            height: auto;
            overflow: visible;
        }
        #summaryModal .modal-dialog, #summaryModal .modal-content {
            width: 100%;
            margin: 0;
            padding: 0;
            border: none;
            background: none;
            box-shadow: none;
        }
        .modal-header, .modal-footer, .btn {
            display: none;
        }
        .table {
            border-collapse: collapse;
        }
        .table th, .table td {
            border: none;
            padding: 2px;
            font-size: 12px;
        }
    }
</style>

<script>
    $(document).ready(function() {
        var typingTimer;
        var doneTypingInterval = 500;

        calculateGrandTotal();
        // Calculate Grand Total
        $('#discount, #tax').on('input', function() {
            calculateGrandTotal();
        });

        // Calculate Change
        $('#payment').on('input', function() {
            clearTimeout(typingTimer);  // Clear the timer on each input
            typingTimer = setTimeout(calculateChange, doneTypingInterval);
        });

        // Save Transaction Button Click
        $('#save-transaction').click(function() {
            saveTransaction();
        });

        // Print Summary Button Click
        $('#print-summary').click(function() {
            populateSummaryModal();
            setTimeout(function() {
                window.print();
            }, 1000);
        });

        // Function to calculate Grand Total
        function calculateGrandTotal() {
            var discount = parseFloat($('#discount').val()) || 0;
            var tax = parseFloat($('#tax').val()) || 0;
            var total = calculateTotal(); // Function to calculate total before discount and tax

            var subtotal = total + (total * (tax / 100))
            var grandTotal = subtotal - discount;
            $('#grand-total').val(grandTotal.toFixed(2));
        }

        // Function to calculate Change
        function calculateChange() {
            var grandTotal = parseFloat($('#grand-total').val()) || 0;
            var payment = parseFloat($('#payment').val()) || 0;

            var change = payment - grandTotal;
            $('#change').val(change.toFixed(2));
        }

        // Function to save transaction (placeholder for your backend logic)
        function saveTransaction() {
            var discount = parseFloat($('#discount').val()) || 0;
            var tax = parseFloat($('#tax').val()) || 0;
            var grandTotal = parseFloat($('#grand-total').val()) || 0;
            var payment = parseFloat($('#payment').val()) || 0;

            // Check if payment is less than grand total
            if (payment < grandTotal) {
                alert('Payment amount must be equal to or greater than the Grand Total.');
                return;
            }

            $.ajax({
                method: 'PUT',  // Use PUT or PATCH as per your Laravel route definition
                url: '/admin/transactions/payOrder/{{ $transaction->id }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    discount: discount,
                    tax: tax,
                    grand_total: grandTotal,
                    payment: payment
                },
                success: function(response) {
                    // Handle success
                    populateSummaryModal();
                    $('#summaryModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error('Error saving transaction:', error);
                }
            });
        }

        // Placeholder function to calculate total before discount and tax
        function calculateTotal() {
            // Implement your logic to calculate total based on transaction details
            // Example: var total = parseFloat($('#total').val()) || 0;
            // Replace this with your actual calculation
            var total = 0;
            $('.table tbody tr').each(function() {
                total += parseFloat($(this).find('td:nth-child(3)').text());
            });
            return total;
        }

        // Function to populate the transaction summary modal
        function populateSummaryModal() {
            var invoice = '{{ $transaction->invoice }}';
            var name = '{{ $transaction->name }}';
            var number = '{{ $transaction->number }}';
            var status = '{{ $transaction->status }}';
            var is_inplace = '{{ $transaction->is_inplace ? "dine-in" : "takeaway" }}';
            var total = '{{ $transaction->total }}';
            var summaryContent = `
                <div class="receipt-header">
                    <h4>Kedai Nasi Bakar Selera</h4>
                    <p>Pusat menu nasi bakar paling original</p>
                </div>
                <div class="receipt-info">
                    <p><strong>No Bon:</strong> ${invoice}</p>
                    <p><strong>Atas Nama:</strong> ${name}</p>
                    <p><strong>Customer:</strong> ${name}</p>
                    <p><strong>Status Pembayaran:</strong> ${status}</p>
                    <p><strong>Order:</strong> ${is_inplace}</p>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            @foreach ($transaction->transaction_details as $detail)
            summaryContent += `
                <tr>
                    <td>{{ $detail->food->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp{{ $detail->total_price }}</td>
                </tr>
            `;
            @endforeach

            summaryContent += `
                    </tbody>
                </table>
                <p><strong>Total Bayar:</strong> Rp${total}</p>
                <p><strong>Pajak:</strong> Rp${$('#tax').val()}</p>
                <p><strong>Diskon:</strong> Rp${$('#discount').val()}</p>
                <p><strong>Grand Total:</strong> Rp${$('#grand-total').val()}</p>
                <p><strong>Bayar:</strong> Rp${$('#payment').val()}</p>
                <p><strong>Kembali:</strong> Rp${$('#change').val()}</p>
            `;

            $('#transaction-summary-content').html(summaryContent);
        }
    });
</script>
@endpush
