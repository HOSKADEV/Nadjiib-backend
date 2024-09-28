<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Information</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table tr {
            height: 30px; /* Adds more space between rows */
        }
        table td {
            padding: 8px 0; /* Adds more space within each cell */
        }
    </style>
</head>
<body>
    <h1>Checkout Details</h1>
    <table>
        <tr>
            <td>ID:</td>
            <td>{{ $checkout->getId() }}</td>
        </tr>
        <tr>
            <td>Customer:</td>
            <td>{{ $checkout->getCustomerId() }}</td>
        </tr>
        <tr>
            <td>Invoice:</td>
            <td>{{ $checkout->getInvoiceId() }}</td>
        </tr>
        <tr>
            <td>Payment Method:</td>
            <td>{{ $checkout->getPaymentMethod() }}</td>
        </tr>
        <tr>
            <td>Amount:</td>
            <td>{{ $checkout->getAmount() }}</td>
        </tr>
        <tr>
            <td>Status:</td>
            <td>{{ $checkout->getStatus() }}</td>
        </tr>
        <tr>
            <td>Description:</td>
            <td>{{ $checkout->getDescription() }}</td>
        </tr>
        <tr>
            <td>Success URL:</td>
            <td>{{ $checkout->getSuccessUrl() }}</td>
        </tr>
        <tr>
            <td>Failure URL:</td>
            <td>{{ $checkout->getFailureUrl() }}</td>
        </tr>
        <tr>
            <td>Fees:</td>
            <td>{{ $checkout->getFees() }}</td>
        </tr>
        <tr>
            <td>Pass Fees to Customer:</td>
            <td>{{ $checkout->getPassFeesToCustomer() ? 'Yes' : 'No' }}</td>
        </tr>
        <tr>
            <td>Locale:</td>
            <td>{{ $checkout->getLocale() }}</td>
        </tr>
        <tr>
            <td>URL:</td>
            <td>{{ $checkout->getUrl() }}</td>
        </tr>
        <tr>
            <td>Created At:</td>
            <td>{{ $checkout->getCreatedAt()->toDateTimeString() }}</td>
        </tr>
        <tr>
            <td>Updated At:</td>
            <td>{{ $checkout->getUpdatedAt()->toDateTimeString() }}</td>
        </tr>
    </table>
</body>
</html>
