@include('components.header', ['page_title' => 'التزكية الروحية'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center px-3">
            <h4>
              <i class="bi bi-hearts text-danger mx-2"></i>
              التزكية الروحية
            </h4>
        </div>

      <hr />
      
      <div class="row mb-3">

        <div class="col-md-6 col-lg-4">
          <a href="{{ route('tazkiia.sessions.index') }}">
            <div class="card text-center py-4 border border-success">
              <div class="card-body">
                <i class="bi bi-book text-success mb-4" style="font-size: 90px !important"></i>
                <h4 class="card-title mb-5"> الحلقات</h4>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-4">
          <a href="{{ route('tazkiia.camps.index') }}" >
            <div class="card text-center py-4 border border-info">
              <div class="card-body">
                <i class="bi bi-microsoft-teams text-info mb-4" style="font-size: 90px !important"></i>
                <h4 class="card-title mb-5"> المعسكرات التربوية </h4>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-4">
          <a href="{{ route('tazkiia.lectures.index') }}" >
            <div class="card text-center py-4 border border-warning">
              <div class="card-body">
                <i class="bi bi-mic-fill text-warning mb-4" style="font-size: 90px !important"></i>
                <h4 class="card-title mb-5">ندوات و محاضرات </h4>
              </div>
            </div>
          </a>  
        </div>

        <div class="my-3 col-md-6 col-lg-4">
          <a href="{{ route('tazkiia.martyrsDocsList') }}" >
            <div class="card text-center py-4 border border-primary">
              <div class="card-body">
                <i class="bi bi-person-rolodex text-primary mb-4" style="font-size: 90px !important"></i>
                <h4 class="card-title mb-5"> توثيق سير الشهداء </h4>
              </div>
            </div>
          </a>  
        </div>

        <div class="my-3 col-md-6 col-lg-4">
          <a href="{{ route('tazkiia.hagsMembersList') }}" >
            <div class="card text-center py-4 border border-success">
              <div class="card-body">
                <i class="fas fa-quran text-success mb-5" style="font-size: 100px !important"></i>
                <h4 class="card-title mb-4"> الحج و العمرة </h4>
              </div>
            </div>
          </a>  
        </div>

        <div class="my-3 col-md-6 col-lg-4">
          <a href="{{ route('tazkiia.communicate.index') }}" >
            <div class="card text-center py-4 border border-secondary">
              <div class="card-body">
                <i class="bi bi-phone text-secondary mb-4" style="font-size: 90px !important"></i>
                <h4 class="card-title mb-5"> التواصل مع اسر الشهداء </h4>
              </div>
            </div>
          </a>  
        </div>

        <div class="my-3 col-md-6 col-lg-4">
          <a href="{{ route('tazkiia.report') }}" >
            <div class="card text-center py-4 border border-danger">
              <div class="card-body">
                <i class="bi bi-journal-bookmark-fill text-danger mb-4" style="font-size: 90px !important"></i>
                <h4 class="card-title mb-5"> التقارير </h4>
              </div>
            </div>
          </a>  
        </div>
        
      </div>

    </div>

  </div>

  @include('components.footer')