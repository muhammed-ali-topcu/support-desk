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
                    <h2>Gmail Inbox</h2>
                    <div>
                        <form method="POST" action="{{ route('gmail.disconnect') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Disconnect</button>
                        </form>
                    </div>
                </div>
                
                {{-- Search Form --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('gmail.search') }}">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search emails..." value="{{ request('q') }}">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                {{-- Emails List --}}
                @if(count($emails) > 0)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Inbox ({{ count($emails) }} emails)</h5>
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
                                    
                                    {{-- Labels --}}
                                    @if(!empty($email['labels']))
                                        <div class="mt-2">
                                            @foreach($email['labels'] as $label)
                                                @if($label !== 'INBOX')
                                                    <span class="badge bg-secondary">{{ $label }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        No emails found in your inbox.
                    </div>
                @endif
            </div>
        </div>
    </div>
    
        
</body>
</html>

