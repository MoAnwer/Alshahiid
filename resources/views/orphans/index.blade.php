@include('components.header', ['page_title' => 'قسم الايتام'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style">
            <li class="breadcrumb-item mx-1">
              <a href="{{ route('home') }}">الرئيسية</a>
              /
            </li>
            <li  class="breadcrumb-item active"> قسم  الايتام</li>
          </ol>
        </nav>

        <hr/>

        <div class="d-flex justify-content-between align-items-center px-3">
            <h4>
              <i class="bi bi-people text-primary mx-2"></i>
              قسم الايتام
            </h4>
        </div>

      <hr />
      
      <div class="row mb-3">

        <div class="col-md-6 col-lg-4">
          <a href="{{ route('orphans.list') }}">
            <div class="card text-center py-4 border border-success">
              <div class="card-body">
                <i class="bi bi-people text-success mb-4" style="font-size: 90px !important"></i>
                <h4 class="card-title mb-5"> قائمة الايتام</h4>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-4">
          <a href="{{ route('orphans.hags') }}" >
            <div class="card text-center py-4 border border-info">
              <div class="card-body">
                <i class="bi bi-newspaper text-info mb-4" style="font-size: 90px !important"></i>
                <h4 class="card-title mb-5"> حج و عمرة للايتام </h4>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-4">
          <a href="{{ route('orphans.medical') }}" >
            <div class="card text-center py-4 border border-warning">
              <div class="card-body">
                <i class="bi bi-newspaper text-warning mb-4" style="font-size: 90px !important"></i>
                <h4 class="card-title mb-5">  العلاج الطبي  للايتام  </h4>
              </div>
            </div>
          </a>  
        </div>

        <div class="my-3 col-md-6 col-lg-4">
          <a href="{{ route('orphans.education') }}" >
            <div class="card text-center py-4 border border-primary">
              <div class="card-body">
                <i class="bi bi-newspaper text-primary mb-4" style="font-size: 90px !important"></i>
                <h4 class="card-title mb-5">  الخدمات التعليمية للايتام  </h4>
              </div>
            </div>
          </a>  
        </div>
        
      </div>

    </div>

  </div>

  @include('components.footer')