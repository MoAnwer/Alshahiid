@include('components.header', ['page_title' => 'تقرير نسبة العجز في مصابي العمليات'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')

      <div class="container-fluid mt-4">
        <h4>تقرير نسبة العجز في مصابي العمليات</h4>
        <button class="mx-4 btn  btn-primary active" onclick="printTable()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
        <hr>
          
        <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">
              
              <div class="col-5">
                <label>القطاع :</label>
                <div class="form-group">
                    <select name="sector" class="form-select">
                      <option value="all">كل القطاعات</option>
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
                      <option value="all">كل المحليات </option>
                      @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                        <option value="{{ $locality }}" @selected(request('locality') == $locality)>{{ $locality }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>

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

            </div>
          </form>
        </div>


        </th>

        @php($totalPer = 0)

        <x-table>
           <x-slot:head>
              <th>نسبة العجز</th>
              <th>80-89</th>
              <th>90-100</th>
              <th>المجموع</th>
            </x-slot:head>
      
           <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>{{ $report['80-89'] }}</td>
              <td>{{ $report['90-100'] }}</td>
              <td>{{ $report['total'] }}</td>
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                @if($report['80-89'] > 0 && $report['total'] > 0)
                  {{ round(($report['80-89'] / $report['total']) * 100, 2) . '%'}}
                  @php($totalPer += ($report['80-89'] / $report['total']) * 100) 
                @else
                  0%
                @endif
              </td>
              <td>
                @if($report['90-100'] > 0 && $report['total'] > 0)
                  {{ round(($report['90-100'] / $report['total']) * 100, 2) . '%'}}
                  @php($totalPer += ($report['90-100'] / $report['total']) * 100)
                @else
                  0%
                @endif
              </td>
              <td>
                @if( $report['total'] > 0)
                  {{ round($totalPer, 2) . '%'}}
                @else
                  0%
                @endif
              </td>
            </tr>

            <caption>
              تقرير نسبة العجز في مصابي العمليات 
               @if(request()->query('sector') != 'all' && !is_null(request()->query('sector')))
                {{ request()->query('sector') }}
              @else
              كل القطاعات
              @endif

              @if( request()->query('locality') == 'all' && !is_null(request()->query('locality'))) 
                كل المحليات
              @else
               محلية  {{ request()->query('locality')  }}
              @endif

            </caption>
           </x-slot:body>

         </x-table>
      </div>
      </div>
    </div>

  @include('components.footer')
  