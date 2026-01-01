 {{-- Auth user --}}
 @php
 $user = Auth::user();
    @endphp

 
 <div class="sidebar" id="sidebar">
     <div class="section">
         <div class="profile-section">
             <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User">
             <div class="profile-details">
                 <h6>{{ $user->name }}</h6>
                 <p style="margin-bottom:0">+91{{ $user->phone }}</p>
             <p>Since {{ $user->created_at->format('d/m/Y') }}</p>
             </div>
            
         </div>
         <div class="close">
             <i class="fa fa-times close-btn" id="closebtn"></i>
         </div>
     </div>


     <div class="menu-list">
         <div onclick="window.location.href='{{ route('home') }}'" class="menu-item"><i class="fa fa-home"></i> Home</div>
         <div onclick="window.location.href='{{ route('account.statement') }}'" class="menu-item"><i class="fa fa-rotate-left"></i> Account Statement</div>
         <div onclick="window.location.href='{{ route('game.rates') }}'" class="menu-item"><i class="fa fa-star"></i> Game Rates</div>
         <div class="menu-item"><i class="fa fa-question-circle"></i> Terms & Conditions</div>
         <div class="menu-item"><i class="fa fa-video"></i> Video</div>
         {{-- <div onclick="window.location.href='{{ route('terms.conditions') }}'" class="menu-item"><i class="fa fa-question-circle"></i> Terms & Conditions</div>
         <div onclick="window.location.href='{{ route('video') }}'" class="menu-item"><i class="fa fa-video"></i> Video</div> --}}
         {{-- <div onclick="window.location.href='{{ route('logout') }}'" class="menu-item"><i class="fa fa-arrow-left"></i> Logout</div> --}}
         <form class="menu-item" action="{{ route('logout') }}" method="POST">
    @csrf
    <button style="border:none" type="submit" class="btn-menu-item text-start">
        <i class="fa fa-arrow-left"></i> Logout
    </button>
</form>

     </div>
 </div>
