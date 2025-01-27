@include('components.header', ['page_title' => 'المشاريع الانتاجية'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <h4>المشاريع الانتاجية</h4>


                <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row">
              
              <div class="col-6">
                <label>القطاع :</label>
                <div class="form-group">
                    <select name="sector" class="form-select">
                      <option value="القطاع الشرقي"  @selected(request('sector') == 'القطاع الشرقي')>القطاع الشرقي</option>
                      <option value="القطاع الشمالي" @selected(request('sector') == 'القطاع الشمالي')>القطاع الشمالي</option>
                      <option value="القطاع الغربي"  @selected(request('sector') == 'القطاع الغربي')>القطاع الغربي</option>
                    </select>
                  </div>
              </div>

              <div class="col-5">
                  <label>المحلية: </label>
                  <div class="form-group">
                    <select name="locality" class="form-select">
                      @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                        <option value="{{ $locality }}" @selected(request('locality') == $locality)>{{ $locality }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>

              <div class="col-1 mt-3 d-flex align-items-center flex-column justify-content-center">
                <button class="btn py-4 btn-primary active form-control ">
                  <i class="fas fa-search ml-2"></i>
                  بحث 
                </button>
              </div>

              </form>

            </div>
        </div> {{-- search form --}}


        <x-table>
           <x-slot:head>
              <th>نسبة العجز</th>
              <th>يعمل</th>
              <th>لا يعمل</th>
              <th>المجموع</th>
            </x-slot:head>
      
           <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>{{ $report['work'] }}</td>
              <td>{{ $report['doesNotWork'] }}</td>
              <td>{{ $report['total'] }}</td>
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                @if($report['work'] > 0)
                  {{ round(($report['work'] / $report['total']) * 100, 1) . '%'}}
                @else
                  0
                @endif
              </td>
              <td>
                @if($report['doesNotWork'] > 0)
                  {{ round(($report['doesNotWork'] / $report['total']) * 100, 1) . '%'}}
                @else
                  0
                @endif
              </td>
              <td>100%</td>
            </tr>

           </x-slot:body>

         </x-table>
      </div>

      </div>
    </div>

  @include('components.footer')