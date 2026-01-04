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
            border-left: 5px solid #3b82f6;
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
        
        .bubble-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; padding: 20px 0; }
        .service-bubble { width: 120px; height: 120px; background: white; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; color: #374151; box-shadow: 0 5px 10px rgba(0,0,0,0.05); transition: all 0.3s ease; border: 3px solid white; text-align: center; }
        .service-bubble:hover { transform: translateY(-5px); border-color: #3b82f6; color: #1e3a8a; }
        .service-bubble span:first-child { font-size: 2rem; }
        .service-bubble span:last-child { font-size: 0.65rem; font-weight: 800; margin-top: 5px; }
    </style>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(Auth::user()->role === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="stat-card" style="border-left-color: #3b82f6;">
                        <div><h4>Total Users</h4><div class="number">{{ \App\Models\User::count() }}</div></div>
                        <div class="stat-icon">👥</div>
                    </div>
                    <div class="stat-card" style="border-left-color: #eab308;">
                        <div><h4>Pending Repairs</h4><div class="number">{{ \App\Models\MaintenanceRequest::where('status', 'Pending')->count() }}</div></div>
                        <div class="stat-icon">🔧</div>
                    </div>
                    <div class="stat-card" style="border-left-color: #ef4444;">
                        <div><h4>Active Health</h4><div class="number">{{ \App\Models\HealthAppointment::where('status', 'Pending')->count() }}</div></div>
                        <div class="stat-icon">🏥</div>
                    </div>
                    <div class="stat-card" style="border-left-color: #22c55e;">
                        <div><h4>Active Deals</h4><div class="number">{{ \App\Models\Deal::count() }}</div></div>
                        <div class="stat-icon">🏷️</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-1 space-y-3">
                        <h3 class="font-bold text-gray-800 px-2 mb-2">Management Console</h3>
                        
                        <a href="{{ route('maintenance.index') }}" class="block p-3 bg-white rounded-lg shadow-sm border-l-4 border-yellow-500 font-bold text-gray-700 hover:bg-gray-50">🔧 Maintenance</a>
                        <a href="{{ route('visitors.index') }}" class="block p-3 bg-white rounded-lg shadow-sm border-l-4 border-purple-500 font-bold text-gray-700 hover:bg-gray-50">📝 Visitor Log</a>
                        <a href="{{ route('transport.index') }}" class="block p-3 bg-white rounded-lg shadow-sm border-l-4 border-green-500 font-bold text-gray-700 hover:bg-gray-50">🚌 Transport</a>
                        <a href="{{ route('health.index') }}" class="block p-3 bg-white rounded-lg shadow-sm border-l-4 border-red-500 font-bold text-gray-700 hover:bg-gray-50">🏥 Health Center</a>
                        <a href="{{ route('polls.index') }}" class="block p-3 bg-white rounded-lg shadow-sm border-l-4 border-pink-500 font-bold text-gray-700 hover:bg-gray-50">📊 Community Polls</a>
                        <a href="{{ route('notices.index') }}" class="block p-3 bg-white rounded-lg shadow-sm border-l-4 border-orange-500 font-bold text-gray-700 hover:bg-gray-50">📢 Notices & Alerts</a>
                        <a href="{{ route('clubs.index') }}" class="block p-3 bg-white rounded-lg shadow-sm border-l-4 border-cyan-500 font-bold text-gray-700 hover:bg-gray-50">🤝 Student Clubs</a>
                        <a href="{{ route('resources.index') }}" class="block p-3 bg-white rounded-lg shadow-sm border-l-4 border-blue-500 font-bold text-gray-700 hover:bg-gray-50">📦 Resource Requests</a>
                        <a href="{{ route('feedback.index') }}" class="block p-3 bg-white rounded-lg shadow-sm border-l-4 border-indigo-500 font-bold text-gray-700 hover:bg-gray-50">💬 View Feedback</a>
                    </div>

                    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold text-gray-800 mb-4">Recent User Registrations</h3>
                        <table class="recent-table">
                            <thead><tr><th>Name</th><th>Role</th><th>Joined</th></tr></thead>
                            <tbody>
                                @foreach(\App\Models\User::latest()->take(8)->get() as $user)
                                    <tr>
                                        <td class="font-bold">{{ $user->name }}</td>
                                        <td><span class="px-2 py-1 rounded text-xs uppercase font-bold bg-gray-100 text-gray-600">{{ $user->role }}</span></td>
                                        <td class="text-sm">{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            @else
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}</h1>
                    <p class="text-gray-500">Campus Services Menu</p>
                </div>

                <div class="bubble-grid">
                    <a href="{{ route('housing.index') }}" class="service-bubble"><span>🏠</span><span>Housing</span></a>
                    <a href="{{ route('cafeteria.index') }}" class="service-bubble"><span>🍔</span><span>Cafeteria</span></a>
                    <a href="{{ route('transport.index') }}" class="service-bubble"><span>🚌</span><span>Transport</span></a>
                    <a href="{{ route('health.index') }}" class="service-bubble"><span>🏥</span><span>Health</span></a>
                    <a href="{{ route('lost-found.index') }}" class="service-bubble"><span>🔍</span><span>Lost&Found</span></a>
                    <a href="{{ route('deals.index') }}" class="service-bubble"><span>🏷️</span><span>Deals</span></a>
                    <a href="{{ route('events.index') }}" class="service-bubble"><span>🎉</span><span>Events</span></a>
                    <a href="{{ route('clubs.index') }}" class="service-bubble"><span>🤝</span><span>Clubs</span></a>
                    <a href="{{ route('polls.index') }}" class="service-bubble"><span>📊</span><span>Polls</span></a>
                    <a href="{{ route('office-hours.index') }}" class="service-bubble"><span>⏰</span><span>Office Hours</span></a>
                    <a href="{{ route('repository.index') }}" class="service-bubble"><span>📚</span><span>Repo</span></a>
                    <a href="{{ route('notices.index') }}" class="service-bubble"><span>📢</span><span>Notices</span></a>
                    <a href="{{ route('gallery.index') }}" class="service-bubble"><span>🖼️</span><span>Gallery</span></a>
                    <a href="{{ route('feedback.index') }}" class="service-bubble"><span>💬</span><span>Feedback</span></a>
                    
                    @if(Auth::user()->role !== 'cafe_owner')
                        <a href="{{ route('maintenance.index') }}" class="service-bubble"><span>🔧</span><span>Repair</span></a>
                    @endif
                    
                    @if(Auth::user()->role === 'teacher')
                        <a href="{{ route('resources.index') }}" class="service-bubble"><span>📦</span><span>Resources</span></a>
                    @endif
                    <a href="{{ route('posts.index') }}" class="service-bubble">
                        <span>📢</span>
                        <span>Campus Post</span>
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>