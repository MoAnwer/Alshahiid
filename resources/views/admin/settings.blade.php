@include('components.header', ['page_title' => ' اعدادات النظام '])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4> اعدادات النظام </h4>
        <hr />
        
        <x-alert />

        @if(Session::has('error'))
          <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif

        <!-- Export backup -->
          <div class="row">

            <div class="col-lg-6 col-12">
              <div class="card shadow-sm mb-3" id="newBackup">
                <div class="card-header py-3 m-0 font-weight-bold text-primary">
                    <i class='bi bi-database-fill'></i> النسخ الإحتياطي لقاعدة البيانات
                </div>

                <div class="card-body">
                  <div class="border mb-0 py-2 px-3 rounded d-flex align-items-center w-100">
                      <div class="ml-4 border-left pl-3 pr-2">
                          <i class="bi bi-database-fill-check text-success h5 mb-0"></i>
                      </div>
                      <div class="d-flex justify-content-between align-items-center  w-100">
                          <span class="h6 mb-0 text-dark">
                            <p class="mt-3 mb-3">اخر عملية نسخ الإحتياطي في : <b dir="ltr">{{ $fileLastModified }}</b></p>
                          </span>          
                          <span class="border-right pr-3">
                            <b>{{ $fileSize }}</b>
                          </span>                
                      </div>
                  </div>
                  <hr>
                  <!-- actions btns -->
                  <div class="d-flex justify-content-end">
                    <form action="{{ route('settings.backup') }}" method="POST">
                      @csrf
                      <button id="backup" class="btn btn-primary active ml-2" title="عمل نسخة احتياطية جديدة لقاعدة البيانات">
                      <i class="bi bi-database-fill mx-1"></i>
                      الاحتفاظ بنسخة احتياطية
                    </button>
                    </form>
                    
                  </div>
                  <!-- actions btns -->

                </div>
                
              </div>
                              
            </div>
              <!-- Export backup -->

            @can('isModerate')
              <!-- import backup -->
              <div class="col-lg-6 col-12 ">
                <div class="card shadow-sm mb-3">
                  <div class="card-header py-3 m-0 font-weight-bold text-primary">
                    <i class='bi bi-database-down'></i> استيراد نسخة الإحتياطية 
                  </div>
                  <div class="card-body py-3">
                    <form action="{{ route('backup.restore') }}" enctype="multipart/form-data"  method="POST">
                      @csrf
                      <div class="form-group py-2">
                        <input type="file" name="backup_file"  class="form-control" accept=".sql" required>
                      </div>
                      <hr>
                      <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary active ml-2">
                          <i class="bi bi-database-down mx-1 mb-1"></i>
                            بدء استيراد
                          </button>
                        </div>
                      </form> 
                    </div>
                  </div>
                </div>
              </div>
            <!-- import backup -->
            @endcan
            
            <hr>
            <span><span class="text-danger">ملاحظة:</span> قد تأخذ عمليات النسخ الاحتياطي وقتاً </span>
                  
    </div>

  </div>

  @include('components.footer')