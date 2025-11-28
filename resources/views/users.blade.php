<x-layout title="Users">
    <style>
        .users-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .user-card {
            background-color: #f5f5f5;
            border: 2px solid #a8a78d;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(93, 64, 55, 0.1);
        }

        .user-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #a8a78d;
            margin-bottom: 15px;
        }

        .user-name {
            color: #5d4037;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .verification-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .verified {
            background-color: #4caf50;
            color: white;
        }

        .pending {
            background-color: #b505f5;
            color: white;
        }
        .rejected {
            background-color: #f44336;
            color: white;
        }

        .no-users {
            text-align: center;
            color: #5d4037;
            font-size: 18px;
            margin-top: 50px;
        }
    </style>

    <div class="users-container">
        <h1 style="color: #5d4037; text-align: center;">Users</h1>
        
        <div class="users-grid">
            @forelse($users as $index => $user)
                @if($index > 0) 
                    <x-user-card :user="$user" />
                @endif
            @empty
                <div class="no-users">
                    No users found in the database.
                </div>
            @endforelse
        </div>
    </div>
</x-layout>