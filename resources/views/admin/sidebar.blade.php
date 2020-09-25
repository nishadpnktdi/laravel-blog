<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="/post/create" class="nav-link">
              <!-- <div class="profile-image">
                <img class="img-xs rounded-circle" src="{{ Auth::user()->profile_photo_url }}" alt="profile image">
                <div class="dot-indicator bg-success"></div>
              </div> -->
              <div class="text-wrapper">
                <!-- <p class="profile-name">{{ Auth::user()->name }}</p> -->
                <p class="designation">New Post</p>
              </div>
            </a>
          </li>
          <li class="nav-item nav-category">Main Menu</li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard">
              <i class="menu-icon typcn typcn-document-text"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/category">
              <i class="menu-icon typcn typcn-shopping-bag"></i>
              <span class="menu-title">Categories</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/tag">
              <i class="menu-icon typcn typcn-th-large-outline"></i>
              <span class="menu-title">Tags</span>
            </a>
          </li>
        </ul>
      </nav>