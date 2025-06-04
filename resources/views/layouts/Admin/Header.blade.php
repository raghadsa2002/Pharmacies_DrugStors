<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
.notification-wrapper {
    position: relative;
    display: inline-block;
    margin-right: 20px;
}

.notification-icon {
    font-size: 22px;
    color: #333;
    position: relative;
    cursor: pointer;
}

.notification-icon .red-dot {
    position: absolute;
    top: 0;
    right: -2px;
    width: 8px;
    height: 8px;
    background-color: red;
    border-radius: 50%;
    border: 2px solid white;
}

.notifications-dropdown {
    position: absolute;
    top: 35px;
    right: 0;
    width: 300px;
    background-color: white;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(239, 230, 230, 0.2);
    display: none;
    z-index: 1000;
}

.notifications-dropdown.active {
    display: block;
}

.notification-item {
    padding: 10px;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item .profCont img {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    margin-right: 10px;
}

.notification-item .txt {
    font-size: 14px;
}

.notification-item .txt.sub {
    font-size: 12px;
    color: #888;
}
</style>

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        Pharam Store
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>

        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
                <div class="input-group">
                    <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                        <span class="input-group-text" id="search">
                            <i class="icon-search"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now"
                        aria-label="search" aria-describedby="search">
                </div>
            </li>
        </ul>

        <ul class="navbar-nav navbar-nav-right">
            {{-- الجرس --}}
            <li class="nav-item">
                @php
                    $user = auth('store_houses')->user(); 
                    $notifications = $user ? $user->notifications->take(5) : collect();
                    $unreadCount = $user ? $user->unreadNotifications->count() : 0;
                @endphp

                <div class="notification-wrapper">
                    <div class="notification-icon" onclick="toggleNotifications()">
                        <i class="fas fa-bell"></i>
                        @if($unreadCount > 0)
                            <span class="red-dot"></span>
                        @endif
                    </div>

                    <div class="notifications-dropdown" id="notificationsDropdown">
                        @forelse($notifications as $notification)
                            <div class="notification-item">
                               
                                <div>
                                    <div class="txt">{{ $notification->data['title'] ?? 'New Notification' }}</div>
                                    <div class="txt sub">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="notification-item">
                                <div class="txt">No notifications</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </li>

            {{-- تسجيل الخروج --}}
            <li class="nav-item">
                <a class="dropdown-item" href="{{ route('admin.logout') }}">
                    <i class="ti-power-off text-primary"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
function toggleNotifications() {
    const dropdown = document.getElementById("notificationsDropdown");
    dropdown.classList.toggle("active");

    // إذا فتحنا القائمة لأول مرة، نرسل طلب تعليم الإشعارات كمقروءة
    if (dropdown.classList.contains("active")) {
        fetch("{{ route('notifications.read') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({})
        }).then(res => {
            if (res.ok) {
                // نخفي النقطة الحمراء
                const dot = document.querySelector(".notification-icon .red-dot");
                if (dot) {
                    dot.style.display = 'none';
                }
            }
        });
    }
}
</script>