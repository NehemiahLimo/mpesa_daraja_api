<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Daraja</title>
</head>
<body>
    <div class="container">

        <div class="row mt-5">
            <div class="col-sm-8 mx-auto">
                <div class="card mt-5">
                    <div class="card-header">Reverse Transaction</div>
                    <div class="card-body">
                        <div id="c2b_response"></div>
                        <form action="">
                            @csrf
                            <div class="form-group">
                                <label for="phone">Transaction Code</label>
                                <input type="text" name="transactionId" class="form-control" id="transactionId">
                            </div>
                            <div class="form-group">
                                <label for="phone">Amount</label>
                                <input type="text" name="amount" class="form-control" id="amount">
                            </div>

                            <button id="reverse" class="btn btn-primary">Reverse Transaction</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>

    document.getElementById('reverse').addEventListener('click', (event) => {
    event.preventDefault()

    const requestBody = {
        transactionId: document.getElementById('transactionId').value,
        amount: document.getElementById('amount').value
        }

    axios.post('reverse-trans', requestBody)
    .then((response) => {
        console.log(response);
        // if(response.data.Result){
        //     //document.getElementById('c2b_response').innerHTML = response.data.Result.ResultDesc
        // } else {
        //     document.getElementById('c2b_response').innerHTML = response.data.errorMessage
        // }
    })
    .catch((error) => {
        console.log(error);
    })
})
</script>
</body>



</html>
