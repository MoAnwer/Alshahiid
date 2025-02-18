@include('components.header', ['page_title' => 'احصائية الأيتام'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div id="printArea">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>احصائية الأيتام</h4>
            <button class="mx-4 btn  btn-primary active" onclick="printTable()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
        </div>

        <hr>

      <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">

              <div class="col-9">
                <label>الفئة العمرية  :</label>
                <div class="form-group">
                    <select name="age" class="form-select">
                      <option value="all">كل الفئات  </option>
                      <option value="under5"  @selected(request('age') == 'under5')>اقل من 5 سنوات</option>
                      <option value="from6To12" @selected(request('age') == 'from6To12')>6 سنوات - 12 سنة </option>
                      <option value="from13To16"  @selected(request('age') == 'from13To16')>13 سنوات - 16 سنة  </option>
                      <option value="from17To18"  @selected(request('age') == 'from17To18')> 17 سنوات - 18 سنة</option>
                    </select>
                  </div>
              </div>

              <!-- <div class="col-3">
                <label>القطاع :</label>
                <div class="form-group">
                    <select name="sector" class="form-select">
                      <option value="all">كل القطاعات</option>
                      <option value="القطاع الشرقي"  @selected(request('sector') == 'القطاع الشرقي')>القطاع الشرقي</option>
                      <option value="القطاع الشمالي" @selected(request('sector') == 'القطاع الشمالي')>القطاع الشمالي</option>
                      <option value="القطاع الغربي"  @selected(request('sector') == 'القطاع الغربي')>القطاع الغربي</option>
                    </select>
                  </div>
              </div> -->

              <!-- <div class="col-5">
                  <label>المحلية: </label>
                  <div class="form-group">
                    <select name="locality" class="form-select">
                      <option value="all">كل المحليات </option>
                      @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                        <option value="{{ $locality }}" @selected(request('locality') == $locality)>{{ $locality }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>
               -->
              <div class="col-1 mt-3 d-flex align-items-center flex-column justify-content-center">
                <button class="btn py-4 btn-primary active form-control " title="بحث ">
                  <i class="bi bi-search ml-2"></i>
                </button>
              </div>

              <div class="col-1 mt-3 d-flex align-items-center flex-column justify-content-center">
              <a class="btn py-4 btn-success active form-control " title="الغاء الفلاتر" href="{{ request()->url() }}">
                  <i class="bi bi-menu-button ml-2"></i>
                </a>


            </div>
          </form>
        </div>

         <x-table>
          <x-slot:head>
            <tr>
              <th>الفئة العمرية </th>
              <th>النوع</th>
              <th>العدد</th>
            </tr>
          </x-slot:head>
          <x-slot:body>
            <tr>
              @if (request('age') == 'all')
                  <td>كل الفئات  </td>
                @elseif (request('age') == 'under5')
                  <td>اقل من 5 سنوات</td>
                @elseif (request('age') == 'from6To12')
                  <td>6 سنوات - 12 سنة </td>
                @elseif (request('age') == 'from13To16')
                  <td>13 سنوات - 16 سنة </td>
                @elseif (request('age') == 'from17To18')
                  <td> 17 سنوات - 18 سنة </td>
                @else 
                  <td>كل الفئات </td>
                @endif

                  <td>ذكر</td>

                <td>{{ $totalMale }}</td>
              </tr>

              <tr>
                @if (request('age') == 'all')
                    <td>كل الفئات </td>
                  @elseif (request('age') == 'under5')
                    <td>اقل من 5 سنوات</td>
                  @elseif (request('age') == 'from6To12')
                    <td>6 سنوات - 12 سنة </td>
                  @elseif (request('age') == 'from13To16')
                    <td>13 سنوات - 16 سنة </td>
                  @elseif (request('age') == 'from17To18')
                    <td> 17 سنوات - 18 سنة </td>
                  @else 
                    <td>كل الفئات </td>
                  @endif

                  <td>أنثى</td>

                <td>{{ $totalFemale }}</td>
              </tr>


              <caption>
                احصائية الأيتام   
               <!--  @if(request()->query('sector') !== 'all' && !is_null(request()->query('sector')))
                  {{ request()->query('sector') }}
                  @else 
                  {{ 'كل القطاعات' }}
                @endif
  
  
                @if(request()->query('locality') == 'all' && !is_null(request()->query('locality')))
                  @if (request()->query('locality') != 'all')
                    {{ '' }}
                  @endif
                @else
                {{ request()->query('locality') ?? 'كل المحليات'}}
                @endif -->
              </caption>
          </x-slot:body>
        </x-table>
        
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

