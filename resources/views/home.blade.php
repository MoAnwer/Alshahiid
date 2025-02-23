@include('components.header', ['page_title' => 'الرئيسية'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center px-3">
            <h2>
              <i class="bi bi-house-fill text-primary active mx-2"></i>
              الرئيسية
            </h2>
        </div>

      <hr />
      
      <div class="row mb-3">
        
        <h5 class="mb-4">الشهداء و الاسر و افراد الاسر</h5>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('martyrs.index') }}">
            <div class="card text-center py-2 border border-warning">
              <div class="card-body">
                <i class="bi bi-star-fill text-warning mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3">قائمة الشهداء</h5>
              </div>
            </div>
          </a>
        </div>

        
        <div class="col-md-6 col-lg-2">
          <a href="{{ route('families.list') }}">
            <div class="card text-center py-2 border border-info">
              <div class="card-body">
                <i class="bi bi-people-fill text-info mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3">قائمة الأسر</h5>
              </div>
            </div>
          </a>
        </div>
        
        <div class="col-md-6 col-lg-2">
          <a href="{{ route('families.index') }}" >
            <div class="card text-center py-2 border border-info">
              <div class="card-body">
                <i class="bi bi-newspaper text-info mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> عدد افراد الاسر  </h5>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('educationServices.index') }}" >
            <div class="card text-center py-2 border border-primary">
              <div class="card-body">
                <i class="bi bi-newspaper text-primary mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3">  الخدمات التعليمية   </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('students.index') }}">
            <div class="card text-center py-2 border border-success">
              <div class="card-body">
                <i class="bi bi-people text-success mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3">الطلاب</h5>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('orphans.index') }}">
            <div class="card text-center py-2 border border-danger">
              <div class="card-body">
                <i class="bi bi-hearts text-danger mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3">قسم الايتام</h5>
              </div>
            </div>
          </a>
        </div>
        

        <div class="col-md-6 col-lg-2 mt-3">
          <a href="{{ route('widows.index') }}">
            <div class="card text-center py-2 border border-info">
              <div class="card-body">
                <i class="bi bi-people-fill text-info mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3">قائمة الأرامل</h5>
              </div>
            </div>
          </a>
        </div>

        {{-- <div class="col-md-6 col-lg-2 mt-3">
          <a href="{{ route('martyrs.moreOneMartyrList') }}">
            <div class="card text-center py-2 border border-warning">
              <div class="card-body">
                <i class="bi bi-people-fill text-warning mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3">الأسر التي لها اكثر من شهيد</h5>
              </div>
            </div>
          </a>
        </div> --}}

        
      </div>

      <hr>
      
      <div class="row mb-3">

          <h5>
            مشرفي الأسر
          </h5>

          
        <div class="col-md-6 col-lg-2 mt-4">
          <a href="{{ route('supervisors.index') }}" >
            <div class="card text-center py-2 border border-success">
              <div class="card-body">
                <i class="bi bi-people-fill text-success mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3">  مشرفي الأسر</h5>
              </div>
            </div>
          </a>  
        </div>


      </div>

      <hr>

      <div class="row mb-3">
        <h5 class="mb-4">الرعاية </h5>
        <div class="col-md-6 col-lg-2">
          <a href="{{ route('projects.index') }}">
            <div class="card text-center py-2 border border-success">
              <div class="card-body">
                <i class="bi bi-tools text-success mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3">  المشاريع الإنتاجية</h5>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('assistances.index') }}" >
            <div class="card text-center py-2 border border-info">
              <div class="card-body">
                <i class="bi bi-newspaper text-info mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> المساعدات </h5>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('medicalTreatment.index') }}" >
            <div class="card text-center py-2 border border-danger">
              <div class="card-body">
                <i class="bi bi-heart text-danger mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> العلاج الطبي </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('medicalTreatment.tamiinList') }}" >
            <div class="card text-center py-2 border border-warning">
              <div class="card-body">
                <i class="bi bi-newspaper text-warning mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> التامين الصحي </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('bails.index', 'show=false') }}" >
            <div class="card text-center py-2 border border-success">
              <div class="card-body">
                <i class="bi bi-cash-coin text-success mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> الكفالات الشهرية </h5>
              </div>
            </div>
          </a>  
        </div>
        
      </div>


      <hr>
      
      <div class="row mb-3">

        <h5>
          التزكية الروحية
        </h5>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('tazkiia.sessions.index') }}">
            <div class="card text-center py-2 border border-success">
              <div class="card-body">
                <i class="bi bi-book text-success mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> الحلقات</h5>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('tazkiia.camps.index') }}" >
            <div class="card text-center py-2 border border-info">
              <div class="card-body">
                <i class="bi bi-microsoft-teams text-info mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> المعسكرات التربوية </h5>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('tazkiia.lectures.index') }}" >
            <div class="card text-center py-2 border border-warning">
              <div class="card-body">
                <i class="bi bi-mic-fill text-warning mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3">ندوات و محاضرات </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('tazkiia.martyrsDocsList') }}" >
            <div class="card text-center py-2 border border-primary">
              <div class="card-body">
                <i class="bi bi-person-rolodex text-primary mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> توثيق سير الشهداء </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('tazkiia.hagsMembersList') }}" >
            <div class="card text-center py-2 border border-success">
              <div class="card-body">
                <i class="bi bi-moon text-success mb-3" style="font-size: 53px !important"></i>
                <h5 class="card-title mb-4"> الحج و العمرة </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('tazkiia.communicate.index') }}" >
            <div class="card text-center py-2 border border-secondary">
              <div class="card-body">
                <i class="bi bi-phone text-secondary mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> التواصل مع اسر الشهداء </h5>
              </div>
            </div>
          </a>  
        </div>

      </div>

      <hr class="mt-4">
      
      <div class="row mb-3">

        <h5 class="mb-4">
         التقارير الفورية
        </h5>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('reports.martyrs') }}">
            <div class="card text-center py-2 border border-success">
              <div class="card-body">
                <i class="bi bi-book text-success mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير الشهداء </h5>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('reports.gross') }}">
            <div class="card text-center py-2 border border-success">
              <div class="card-body">
                <i class="bi bi-cash-coin text-success mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير الاجمالي العام </h5>
              </div>
            </div>
          </a>
        </div>


        <div class="col-md-6 col-lg-2">
          <a href="{{ route('reports.homes') }}" >
            <div class="card text-center py-2 border border-info">
              <div class="card-body">
                <i class="bi bi-microsoft-teams text-info mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3">  تقرير مشاريع السكن </h5>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('reports.address') }}" >
            <div class="card text-center py-2 border border-warning">
              <div class="card-body">
                <i class="bi bi-mic-fill text-warning mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير السكن  </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('marryAssistances.report') }}" >
            <div class="card text-center py-2 border border-primary">
              <div class="card-body">
                <i class="bi bi-person-rolodex text-primary mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير اعانات الزواج</h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2">
          <a href="{{ route('reports.assistances') }}" >
            <div class="card text-center py-2 border border-success">
              <div class="card-body">
                <i class="bi bi-moon text-success mb-3" style="font-size: 53px !important"></i>
                <h5 class="card-title mb-4"> تقرير المساعدات </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2 mt-4">
          <a href="{{ route('reports.projectsWorkStatusReport') }}" >
            <div class="card text-center py-2 border border-success">
              <div class="card-body">
                <i class="bi bi-moon text-success mb-3" style="font-size: 53px !important"></i>
                <h5 class="card-title mb-4"> تقرير المشاريع الإنتاجية </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2 mt-4">
          <a href="{{ route('reports.educationServices') }}" >
            <div class="card text-center py-2 border border-secondary">
              <div class="card-body">
                <i class="bi bi-phone text-secondary mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير التعليم</h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2 mt-4">
          <a href="{{ route('tazkiia.report') }}" >
            <div class="card text-center py-2 border border-danger">
              <div class="card-body">
                <i class="bi bi-journal-bookmark-fill text-danger mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير التزكية الروحية </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2 mt-4">
          <a href="{{ route('reports.bails') }}" >
            <div class="card text-center py-2 border border-danger">
              <div class="card-body">
                <i class="bi bi-journal-bookmark-fill text-danger mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير  الكفالات </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2 mt-4">
          <a href="{{ route('reports.students') }}" >
            <div class="card text-center py-2 border border-danger">
              <div class="card-body">
                <i class="bi bi-journal-bookmark-fill text-danger mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير  إحصاء طلاب </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2 mt-4">
          <a href="{{ route('reports.medicalTreatment') }}" >
            <div class="card text-center py-2 border border-danger">
              <div class="card-body">
                <i class="bi bi-journal-bookmark-fill text-danger mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير  العلاج الطبي </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-2 mt-4">
          <a href="{{ route('medicalTreatment.tamiin') }}" >
            <div class="card text-center py-2 border border-danger">
              <div class="card-body">
                <i class="bi bi-journal-bookmark-fill text-danger mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير  التأمين الصحي </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-3 mt-4">
          <a href="{{ route('reports.injuredServices') }}" >
            <div class="card text-center py-2 border border-danger">
              <div class="card-body">
                <i class="bi bi-journal-bookmark-fill text-danger mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير خدمات مصابي العمليات  </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-3 mt-4">
          <a href="{{ route('reports.injureds') }}" >
            <div class="card text-center py-2 border border-danger">
              <div class="card-body">
                <i class="bi bi-journal-bookmark-fill text-danger mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير نسبة عجز مصابي العمليات </h5>
              </div>
            </div>
          </a>  
        </div>

        <div class="col-md-6 col-lg-3 mt-4">
          <a href="{{ route('reports.injuredsTamiin') }}" >
            <div class="card text-center py-2 border border-danger">
              <div class="card-body">
                <i class="bi bi-journal-bookmark-fill text-danger mb-4" style="font-size: 60px !important"></i>
                <h5 class="card-title mb-3"> تقرير التأمين الصحي مصابي العمليات </h5>
              </div>
            </div>
          </a>  
        </div>

      </div>



    </div>

  </div>

  @include('components.footer')