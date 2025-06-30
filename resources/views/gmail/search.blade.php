<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Search Results</h2>
                <a href="{{ route('gmail.index') }}" class="btn btn-secondary">Back to Inbox</a>
            </div>
            
            {{-- Search Form --}}
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('gmail.search') }}">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search emails..." value="{{ $query }}">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            
            @if(count($emails) > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Search Results for "{{ $query }}" ({{ count($emails) }} emails)</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($emails as $email)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $email['subject'] ?: '(No Subject)' }}</h6>
                                    <small>{{ $email['timestamp'] }}</small>
                                </div>
                                <p class="mb-1"><strong>From:</strong> {{ $email['from'] }}</p>
                                <small>{{ Str::limit(strip_tags($email['body']), 150) }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    No emails found matching your search criteria.
                </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>
