@include('components.header', ['page_title' => 'التأمين الصحي'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex align-items-center">
            <h4>التأمين الصحي</h4>
              <button class="mx-4 btn  btn-primary active" onclick="printTable()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
              </button>
        </div>
        <hr>

      <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">
              
              <div class="row px-1 mt-4">
              <div class="col-2">
              <label>القوة: </label>
                  <div class="form-group">
                  <select class="form-select" name="force">
                    <option value="all">الكل</option>
                    @foreach(['جهاز الأمن','شرطة موحدة','قوات مسلحة','قرارات','شهداء الكرامة'] as $force)
                      <option value="{{ $force }}" @selected(request('force') == $force)>{{ $force }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              

              <div class="col-3">
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

              <div class="col-2">
                <label>ذكور و إناث :</label>
                <div class="form-group">
                    <select name="gender" class="form-select">
                      <option value="all">ذكور و إناث</option>
                      <option value="ذكر"  @selected(request('gender') == 'ذكر')>ذكور</option>
                      <option value="أنثى" @selected(request('gender') == 'أنثى')>إناث</option>
                    </select>
                  </div>
              </div>

              <div class="col-2">
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

        <hr>

        @php($totalPer = 0)

        <x-table>
           <x-slot:head>
              <th>نسبة العجز</th>
              <th>العدد المؤمن</th>
              <th>غير مؤمن</th>
              <th>المجموع</th>
            </x-slot:head>
      
           <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>{{ number_format($report['has']) }}</td>
              <td>{{ number_format($report['no']) }}</td>
              <td>{{ number_format($report['total']) }}</td>
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                @if($report['has'] > 0 &&  $report['total'] > 0)
                  {{ round(($report['has'] / $report['total']) * 100, 1) . '%'}}
                  @php($totalPer += ($report['has'] / $report['total']) * 100)
                @else
                  0%
                @endif
              </td>
              <td>
                @if($report['no'] > 0 &&  $report['total'] > 0)
                  {{ round(($report['no'] / $report['total']) * 100, 1) . '%'}}
                  @php($totalPer += ($report['no'] / $report['total']) * 100)
                @else
                  0%
                @endif
              </td>
              <td>
                @if($report['total'] > 0)
                  {{ round($totalPer, 1) .'%' }}
                @else
                  0%
                @endif
              </td>
            </tr>

            <caption class="text-primary">
              تقرير  التأمين الصحي لاسر
                @if(request()->query('force') != 'all')
                {{ request()->query('force') }}
                @endif

                 @if(request()->query('gender') != 'all')
                {{ request()->query('gender') }}
                @endif


              @if(request()->query('sector') != 'all' || is_null(request()->query('sector')))
                {{ request()->query('sector') }}
              @else
              كل القطاعات
              @endif

              @if( request()->query('locality') == 'all' || is_null(request()->query('locality'))) 
                كل المحليات
              @else
              {{ '-' . request()->query('locality')  }}
              @endif

                @empty(!request()->query('year'))
                {{ 'سنة ' . request()->query('year')  . (request()->query('month') != '' ?  ' شهر ' . request()->query('month') : ' لكل الشهور     ')}}
              @endempty

            </caption>

           </x-slot:body>

         </x-table>
      </div>

      </div>
    </div>

  @include('components.footer')