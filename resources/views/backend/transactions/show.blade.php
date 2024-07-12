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
                            <tr>
                                <td colspan="2" class="text-right"><strong>Tax (%)</strong></td>
                                <td><input type="number" id="tax" name="tax" class="form-control" placeholder="Enter tax percentage"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right"><strong>Discount (Rp.)</strong></td>
                                <td><input type="number" id="discount" name="discount" class="form-control" placeholder="Enter discount amount"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right"><strong>Grand Total</strong></td>
                                <td><input type="text" id="grand-total" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right"><strong>Payment</strong></td>
                                <td><input type="number" id="payment" name="payment" class="form-control" placeholder="Enter payment amount"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right"><strong>Change</strong></td>
                                <td><input type="text" id="change" class="form-control" readonly></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <button id="save-transaction" class="btn btn-lg w-50 btn-success text-white">Bayar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Summary -->
            <div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="summaryModalLabel">Transaction Summary</h5>
                            <button type="button" id="closed-transaction" class="btn-close" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Summary details will be filled here via jQuery -->
                            <div id="transaction-summary-content" class="receipt"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="closed2-transaction" class="btn btn-secondary">Close</button>
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

        calculateGrandTotal(); // Calculate Grand Total on page load

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
        $('#closed-transaction').click(function() {
            $('#summaryModal').modal('hide');
        });
        $('#closed2-transaction').click(function() {
            $('#summaryModal').modal('hide');
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

            var subtotal = total + (total * (tax / 100));
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

        // Function to calculate total before discount and tax
        function calculateTotal() {
            var total = 0;
            $('.table tbody tr').each(function() {
                var price = parseFloat($(this).find('td:nth-child(3)').text()) || 0;
                total += price;
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
            var total = calculateTotal();
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
                <p><strong>Total Bayar:</strong> Rp${total.toFixed(2)}</p>
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
