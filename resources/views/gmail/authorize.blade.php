<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Connect Gmail') }}</div>
                    <div class="card-body text-center">
                        <h5>Gmail Integration</h5>
                        <p>Connect your Gmail account to access your emails programmatically.</p>

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <a href="{{ route('gmail.authorize') }}" class="btn btn-primary">
                            <i class="fab fa-google"></i> Connect Gmail Account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>