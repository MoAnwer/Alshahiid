@include('components.header', ['page_title' => "القسم التعليمي "])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>
            <i class="bi bi-person-video3 fs-3 ml-1"></i>
            القسم التعليمي 
          </h3>
        </div>

        <div class="mt-4">

          <div class="row row-cols-1 row-cols-md-3 g-6 mb-6" style="gap: 15px 0px;">

            <div class="col">
              <div class="card h-100">
                <img class="card-img-top" src="{{ asset('asset/images/logo.jpg') }}" alt="Card image cap" />
                <div class="card-body">
                  <h5 class="card-title">واجهة البرنامج</h5>
                  <hr />
                  <p class="card-text mt-4">
                   جولة عامة في كل ما يخص البرنامج و الشاشات و الواجهات 
                  </p>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card h-100">
                <img class="card-img-top" src="{{ asset('asset/images/logo.jpg') }}" alt="Card image cap" />
                <div class="card-body">
                  <h5 class="card-title">اضافة بيانات شهيد جديد الى البرنامج</h5>
                  <hr />
                  <p class="card-text mt-4">
                   جولة عامة في كل ما يخص البرنامج و الشاشات و الواجهات 
                  </p>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card h-100">
                <img class="card-img-top" src="{{ asset('asset/images/logo.jpg') }}" alt="Card image cap" />
                <div class="card-body">
                  <h5 class="card-title">اضافة بيانات شهيد جديد الى البرنامج</h5>
                  <hr />
                  <p class="card-text mt-4">
                   جولة عامة في كل ما يخص البرنامج و الشاشات و الواجهات 
                  </p>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card h-100">
                <img class="card-img-top" src="{{ asset('asset/images/logo.jpg') }}" alt="Card image cap" />
                <div class="card-body">
                  <h5 class="card-title">اضافة بيانات شهيد جديد الى البرنامج</h5>
                  <hr />
                  <p class="card-text mt-4">
                   جولة عامة في كل ما يخص البرنامج و الشاشات و الواجهات 
                  </p>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card h-100">
                <img class="card-img-top" src="{{ asset('asset/images/logo.jpg') }}" alt="Card image cap" />
                <div class="card-body">
                  <h5 class="card-title">اضافة بيانات شهيد جديد الى البرنامج</h5>
                  <hr />
                  <p class="card-text mt-4">
                   جولة عامة في كل ما يخص البرنامج و الشاشات و الواجهات 
                  </p>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card h-100">
                <img class="card-img-top" src="{{ asset('asset/images/logo.jpg') }}" alt="Card image cap" />
                <div class="card-body">
                  <h5 class="card-title">اضافة بيانات شهيد جديد الى البرنامج</h5>
                  <hr />
                  <p class="card-text mt-4">
                   جولة عامة في كل ما يخص البرنامج و الشاشات و الواجهات 
                  </p>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card h-100">
                <img class="card-img-top" src="{{ asset('asset/images/logo.jpg') }}" alt="Card image cap" />
                <div class="card-body">
                  <h5 class="card-title">اضافة بيانات شهيد جديد الى البرنامج</h5>
                  <hr />
                  <p class="card-text mt-4">
                   جولة عامة في كل ما يخص البرنامج و الشاشات و الواجهات 
                  </p>
                </div>
              </div>
            </div>



          </div>


        </div> 



      </div>

    </div>

  @include('components.footer')