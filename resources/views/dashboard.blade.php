<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(Auth::user()->role === 'admin')
                {{ __('System Administration') }}
            @else
                {{ __('Student Portal') }}
            @endif
        </h2>
    </x-slot>

    <style>
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 5px solid #3b82f6; /* Default Blue */
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .stat-card h4 { color: #6b7280; font-size: 0.9rem; font-weight: 600; text-transform: uppercase; }
        .stat-card .number { font-size: 1.8rem; font-weight: 800; color: #111827; }
        .stat-icon { font-size: 2rem; opacity: 0.2; }
        
        .recent-table { width: 100%; border-collapse: collapse; }
        .recent-table th { text-align: left; padding: 12px; border-bottom: 2px solid #f3f4f6; color: #6b7280; font-size: 0.8rem; }
        .recent-table td { padding: 12px; border-bottom: 1px solid #f3f4f6; color: #374151; }
        
        /* Bubble Styles for Students (Kept from previous design) */
        .bubble-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 25px; padding: 40px 0; }
        .service-bubble { width: 130px; height: 130px; background: white; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; color: #374151; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); transition: all 0.3s ease; border: 4px solid white; animation: float 6s ease-in-out infinite; }
        .service-bubble:hover { transform: translateY(-10px) scale(1.05); border-color: #3b82f6; color: #1e3a8a; }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-8px); } 100% { transform: translateY(0px); } }
    </style>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(Auth::user()->role === 'admin')
            
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Admin Overview</h1>
                        <p class="text-gray-500">Here is what's happening on campus today.</p>
                    </div>
                    <button onclick="alert('Generating System Report...')" class="bg-gray-800 text-white px-4 py-2 rounded shadow hover:bg-black transition">
                        📥 Download Report
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    
                    <div class="stat-card" style="border-left-color: #3b82f6;">
                        <div>
                            <h4>Total Users</h4>
                            <div class="number">{{ \App\Models\User::count() }}</div>
                        </div>
                        <div class="stat-icon text-blue-600">👥</div>
                    </div>

                    <div class="stat-card" style="border-left-color: #eab308;">
                        <div>
                            <h4>Pending Repairs</h4>
                            <div class="number">{{ \App\Models\MaintenanceRequest::where('status', 'Pending')->count() }}</div>
                        </div>
                        <div class="stat-icon text-yellow-600">🔧</div>
                    </div>

                    <div class="stat-card" style="border-left-color: #ef4444;">
                        <div>
                            <h4>Lost Items</h4>
                            <div class="number">{{ \App\Models\LostItem::where('status', 'Lost')->count() }}</div>
                        </div>
                        <div class="stat-icon text-red-600">🔍</div>
                    </div>

                    <div class="stat-card" style="border-left-color: #22c55e;">
                        <div>
                            <h4>Active Deals</h4>
                            <div class="number">{{ \App\Models\Deal::count() }}</div>
                        </div>
                        <div class="stat-icon text-green-600">🏷️</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-1 space-y-4">
                        <h3 class="font-bold text-gray-800 mb-2">Management Console</h3>
                        
                        <a href="{{ route('maintenance.index') }}" class="block p-4 bg-white rounded-lg shadow hover:bg-gray-50 border-l-4 border-yellow-500 flex justify-between items-center">
                            <span class="font-bold text-gray-700">Maintenance Requests</span>
                            <span class="text-gray-400">➜</span>
                        </a>
                        
                        <a href="{{ route('visitors.index') }}" class="block p-4 bg-white rounded-lg shadow hover:bg-gray-50 border-l-4 border-purple-500 flex justify-between items-center">
                            <span class="font-bold text-gray-700">Visitor Log</span>
                            <span class="text-gray-400">➜</span>
                        </a>

                        <a href="{{ route('transport.index') }}" class="block p-4 bg-white rounded-lg shadow hover:bg-gray-50 border-l-4 border-green-500 flex justify-between items-center">
                            <span class="font-bold text-gray-700">Manage Transport</span>
                            <span class="text-gray-400">➜</span>
                        </a>

                        <a href="{{ route('resources.index') }}" class="block p-4 bg-white rounded-lg shadow hover:bg-gray-50 border-l-4 border-blue-500 flex justify-between items-center">
                            <span class="font-bold text-gray-700">Resource Requests</span>
                            <span class="text-gray-400">➜</span>
                        </a>

                        <a href="{{ route('feedback.index') }}" class="block p-4 bg-white rounded-lg shadow hover:bg-gray-50 border-l-4 border-indigo-500 flex justify-between items-center">
                            <span class="font-bold text-gray-700">View Feedback</span>
                            <span class="text-gray-400">➜</span>
                        </a>
                    </div>

                    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold text-gray-800 mb-4">System Health</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Server Load</span>
                                    <span class="text-green-600 font-bold">12%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 12%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Database Capacity</span>
                                    <span class="text-blue-600 font-bold">45%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>

                            <hr class="my-6">

                            <h3 class="font-bold text-gray-800 mb-2">Recent User Registrations</h3>
                            <table class="recent-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                                        <tr>
                                            <td class="font-bold">{{ $user->name }}</td>
                                            <td>
                                                <span class="px-2 py-1 rounded text-xs uppercase font-bold bg-gray-100 text-gray-600">
                                                    {{ $user->role }}
                                                </span>
                                            </td>
                                            <td class="text-sm">{{ $user->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @else
            
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}</h1>
                    <p class="text-gray-500">Access your campus services below</p>
                </div>

                <div class="bubble-grid">
                    <a href="{{ route('housing.index') }}" class="service-bubble">
                        <span class="text-3xl mb-2">🏠</span>
                        <span class="font-bold text-sm uppercase">Housing</span>
                    </a>
                    <a href="{{ route('lost-found.index') }}" class="service-bubble">
                        <span class="text-3xl mb-2">🔍</span>
                        <span class="font-bold text-sm uppercase">Lost & Found</span>
                    </a>
                    <a href="{{ route('transport.index') }}" class="service-bubble">
                        <span class="text-3xl mb-2">🚌</span>
                        <span class="font-bold text-sm uppercase">Transport</span>
                    </a>
                    <a href="{{ route('deals.index') }}" class="service-bubble">
                        <span class="text-3xl mb-2">🏷️</span>
                        <span class="font-bold text-sm uppercase">Deals</span>
                    </a>
                    <a href="{{ route('cafeteria.index') }}" class="service-bubble">
                        <span class="text-3xl mb-2">🍔</span>
                        <span class="font-bold text-sm uppercase">Cafeteria</span>
                    </a>
                    <a href="{{ route('feedback.index') }}" class="service-bubble">
                        <span class="text-3xl mb-2">💬</span>
                        <span class="font-bold text-sm uppercase">Feedback</span>
                    </a>
                    @if(Auth::user()->role !== 'cafe_owner')
                    <a href="{{ route('maintenance.index') }}" class="service-bubble">
                        <span class="text-3xl mb-2">🔧</span>
                        <span class="font-bold text-sm uppercase">Repair</span>
                    </a>
                    @endif
                    @if(Auth::user()->role === 'teacher')
                    <a href="{{ route('resources.index') }}" class="service-bubble">
                        <span class="text-3xl mb-2">📦</span>
                        <span class="font-bold text-sm uppercase">Resources</span>
                    </a>
                    @endif
                </div>

            @endif

        </div>
    </div>
</x-app-layout>