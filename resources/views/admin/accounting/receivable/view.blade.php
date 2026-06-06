<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Invoice Template</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .invoice-container {
            max-width: 800px;
            margin: 50px auto;
        }
        .invoice-header {
            
        }
        .invoice-body {
            padding: 20px;
        }
        .invoice-footer {
            background-color: #f8f9fa;
            padding: 20px;
        }
    </style>
</head>
<body>
            
    <div class="container invoice-container">

        <div class="invoice-header" style="background-color: #4c1864 !important;
            padding: 20px;">
            <h3 class="text-center" style="color: white;">Invoice # {{ $view->invoice }}</h3>
        </div>
        <div class="invoice-body">
            <div class="row">
                <div class="col-md-12">
                	<p>Date : {{date('d M Y', strtotime($view->created_at));}}</p>
                </div>
            </div>
            <table class="table">
            	<tr>
            		<td>
            			<span><b>From:</b></span><br>
	                    <span>konnect yatra.US INC.</span><br>
	                    <span class="pb-0 mb-0">18502 Hillside Avenue</span><br>
	                    <span>Jamaica, NY 11432</span><br>
	                    <span>+1 718-908-9464</span><br>
            		</td>
            		<td>
            			<span><b>To:</b></span><br>
	                    <span>{{ $view->account_head->name }}</span><br>
	                    <span>{{ $view->account_head->address }}</span><br>
	                    <span>{{ $view->account_head->phone }}</span><br>
            		</td>
            	</tr>
            </table>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th class="text-dark">Subject</th>
			            <th class="text-dark">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $view->subject }}</td>
			            <td>${{ $view->amount }}</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
            <div class="text-right">
                <p><strong>Total:</strong> ${{ $view->amount }}</p>
            </div>
        </div>
    </div>
        
<!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
