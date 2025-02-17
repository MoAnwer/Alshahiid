@include('components.header', ['page_title' => 'احصائيات ادخال المستخدم ' . $user->username])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">

        <div id="printArea">
          
       
        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>
            <i class="fas fa-pepole"></i>
              احصائيات  الإدخال  لـ  {{ $user->username }}
          </h3>
          <span>التاريخ : <b dir="ltr">{{ date('Y-m-d H:i:sa') }}</b></span>
        </div>

        <hr>


        
        <div class="row px-3">
          
         <div class="col-md-6 col-lg-4 mt-3">
            <div class="card text-center py-2 border border-primary">
              <div class="card-body">
                <i class="bi bi-people-fill text-primary mb-4" style="font-size: 90px !important"></i>
                <h3 class="card-title mb-3">{{ number_format($martyrsStats) }}</h3>
                <h6>عدد  الشهداء الذين ادخلهم  {{ $user->username }} اليوم </h6>
              </div>
            </div>
          </div>


         <div class="col-md-6 col-lg-4 mt-3">
            <div class="card text-center py-2 border border-primary">
              <div class="card-body">
                <i class="bi bi-people-fill text-primary mb-4" style="font-size: 90px !important"></i>
                <h3 class="card-title mb-3">{{ number_format($familiesStats) }}</h3>
                <h6>عدد  اسر الشهداء الذين ادخلهم  {{ $user->username }} اليوم </h6>
              </div>
            </div>
          </div>

        </div>

      </div>

        <div class="d-flex align-items-end mt-5 align-items-end">
            <button class="mx-4 btn py-4 btn-primary active form-control" onclick="printContainer()">
            <i class="bi bi-printer ml-2"></i>
              طباعة 
            </button>
        </div>


    </div>

  </div>

@include('components.footer')