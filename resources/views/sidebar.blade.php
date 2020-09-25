<!-- Widget [Search Bar Widget]-->
<div class="widget search">
    <header>
        <h3 class="h6">Search the blog</h3>
    </header>
    <form action="#" class="search-form">
        <div class="form-group">
            <input type="search" placeholder="What are you looking for?">
            <button type="submit" class="submit"><i class="icon-search"></i></button>
        </div>
    </form>
</div>
<!-- Widget [Latest Posts Widget]        -->
<div class="widget latest-posts">
    <header>
        <h3 class="h6">Latest Posts</h3>
    </header>
    <div class="blog-posts">
        @foreach ($latest as $post)
        <a href="#">
            <div class="item d-flex align-items-center">
                <div class="image">
                    <img src="/images/{{$post->featured_image}}" alt="..." class="img-fluid">
                </div>
                <div class="title">
                    <strong>{{$post->title}}</strong>
                    <div class="d-flex align-items-center">
                        <div class="views"><i class="icon-eye"></i> 500</div>
                        <div class="comments"><i class="icon-comment"></i>12</div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
<!-- Widget [Categories Widget]-->
<div class="widget categories">
    <header>
        <h3 class="h6">Categories</h3>
    </header>
    @foreach ($categories as $category)
    <div class="item d-flex justify-content-between"><a href="#">{{$category->name}}</a><span>{{$category->posts_count}}</span></div>
    @endforeach
</div>
<!-- Widget [Tags Cloud Widget]-->
<div class="widget tags">
    <header>
        <h3 class="h6">Tags</h3>
    </header>
    <ul class="list-inline">
        @foreach($tags as $tag)
        <li class="list-inline-item"><a href="#" class="tag">{{$tag->name}}</a></li>
        @endforeach
    </ul>
</div>