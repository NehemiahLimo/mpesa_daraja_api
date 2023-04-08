<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Laravel Daraja</title>

    <style>
        #mpesaresponse {
            height: 200px;
            overflow: auto;
        }
    </style>



</head>
<body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-sm-4 mx-auto">
                <div class="card">
                    <div class="card-header">
                        Obtain Access Token
                    </div>
                    <div class="card-body">
                        <h4 id="access_token"></h4>
                        <button id="fetchtoken" class="btn btn-primary">Request Access Token</button>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-header">Register URLs</div>
                    <div class="card-body">
                        <div id="response"></div>
                        <button id="registerURLS" class="btn btn-primary">Register URLs</button>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-header">Simulate Transaction</div>
                    <div class="card-body">
                        <div id="c2b_response"></div>
                        <form action="">
                            @csrf
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" class="form-control" id="amount">
                            </div>
                            <div class="form-group">
                                <label for="account">Account</label>
                                <input type="text" name="account" class="form-control" id="account">
                            </div>
                            <button id="simulate" class="btn btn-primary">Simulate Payment</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Sidebar -->
            <div class="col-md-8 border border-success">
                <div class="sidebar" id="mpesaresponse" style="background-color: #f2f2f2; margin-top:20px; padding: 20px; border: 1px solid #ccc;">
                    <p id="mpesaresponse">MPesa Response here</p>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384"> </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>

        document.getElementById('fetchtoken').addEventListener('click',(event)=>{
            event.preventDefault()

            axios.post('get-access-token',{})
            .then((response)=>{
                //alert(response);
                console.log(response);
                document.getElementById('access_token').innerHTML= response.data;
                //document.getElementById('mpesaresponse').innerHTML= response.data;
                // Assuming the mpesaresponse element is already defined
                const mpesaResponseElement = document.getElementById('mpesaresponse');

                // Clear the current content of the element
                mpesaResponseElement.innerHTML = '';

                // Add the response content to the element
                mpesaResponseElement.innerHTML = `<pre><code>${JSON.stringify(response.data, null, 2)}</code></pre>`;

            }).catch((error)=>
            {
                console.log(error);
            })
        })

        document.getElementById('registerURLS').addEventListener('click', (event)=>{
    event.preventDefault()


    axios.post('register-urls',{})
    .then((response)=>{
        console.log(response);
        if(response.data.ResponseDescription){
            //)
            document.getElementById('response').innerHTML = response.data.ResponseDescription;
            //document.getElementById('mpesaresponse').innerHTML= JSON.stringify(response.data);

                        // Assuming the mpesaresponse element is already defined
                        const mpesaResponseElement = document.getElementById('mpesaresponse');

                        // Clear the current content of the element
                        mpesaResponseElement.innerHTML = '';

                        // Add the response content to the element
                        mpesaResponseElement.innerHTML = `<pre><code>${JSON.stringify(response.data, null, 2)}</code></pre>`;



        }else{
            document.getElementById('response').innerHTML = "Register URL wasn't succesfull because :"+response.data.errorMessage;


        }

    })
    .catch((error)=>{
        console.log(error);
    })
})


document.getElementById('simulate').addEventListener('click', (event) => {
    event.preventDefault()

    const requestBody = {
        amount: document.getElementById('amount').value,
        account: document.getElementById('account').value
    }

    axios.post('/simulate', requestBody)
    .then((response) => {
        if(response.data.ResponseDescription){


            document.getElementById('c2b_response').innerHTML = response.data.ResponseDescription

                        // Assuming the mpesaresponse element is already defined
            const mpesaResponseElement = document.getElementById('mpesaresponse');

            // Clear the current content of the element
            mpesaResponseElement.innerHTML = '';

            // Add the response content to the element
            mpesaResponseElement.innerHTML = `<pre><code>${JSON.stringify(response.data, null, 2)}</code></pre>`;
                        //document.getElementById('mpesaresponse').innerHTML= JSON.stringify(response.data);


        } else {
            document.getElementById('c2b_response').innerHTML = response.data.errorMessage
        }
    })
    .catch((error) => {
        console.log(error);
    })
})
    </script>
</body>
</html>
