<x-layout title="Departments">
    <style>
        .departments-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .departments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .departments-title {
            color: #5d4037;
            text-align: center;
            margin: 0;
        }

        .departments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .department-card {
            background-color: #f5f5f5;
            border: 2px solid #a8a78d;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(93, 64, 55, 0.1);
            transition: all 0.3s ease;
        }

        .department-card-link:hover .department-card {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(93, 64, 55, 0.15);
        }

        .department-image-placeholder {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .department-location {
            color: #5d4037;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .department-specs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .spec-item {
            background-color: #a8a78d;
            color: #5d4037;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .department-rent {
            color: #5d4037;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .department-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .department-status.furnished {
            background-color: #4caf50;
            color: white;
        }

        .department-status.unfurnished {
            background-color: #f44336;
            color: white;
        }

        .department-status.partially furnished {
            background-color: #ff9800;
            color: white;
        }

        .no-departments {
            text-align: center;
            color: #5d4037;
            font-size: 18px;
            margin-top: 50px;
            grid-column: 1 / -1;
        }

        .department-card-link {
            text-decoration: none;
            color: inherit;
        }
    </style>

    <div class="departments-container">
        <div class="departments-header">
            <h1 class="departments-title">Departments</h1>
        </div>
        
        <div class="departments-grid">
            @forelse($departments as $department)
                <x-department-card :department="$department" />
            @empty
                <div class="no-departments">
                    No departments found in the database.
                </div>
            @endforelse
        </div>
    </div>
</x-layout>