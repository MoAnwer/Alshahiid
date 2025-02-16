@include('components.header', ['page_title' => 'احصاء الشهداء'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>احصاء الشهداء</h4>
        </div>

        @php
          $totalCount = 0;
        @endphp
        <hr>
         <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">
              
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

              <div class="col-4">
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

              <div class="col-2">
                  <label>السنة: </label>
                  <div class="form-group">
                    <input type="number" class="py-4 form-control" max="2100" min="1900" step="1" name="year" placeholder="{{ request('year') }}" />
                  </div>
                </div>

              <div class="col-1">
                  <label>الشهر: </label>
                  <div class="form-group">
                    <input type="number" class="py-4 form-control" min="1" max="12" step="1" name="month" placeholder="{{ request('month') }}" />
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
              </form>

            </div>
        </div>


        
        <x-table>
          <x-slot:head>
            <th>القوة</th>
            <th>قوات مسلحة</th>
            <th>شرطة موحدة</th>
            <th>جهاز الأمن</th>
            <th>قرارات</th>
            <th>شهداء الكرامة</th>
            <th>الاجمالي</th>
          </x-slot:head>
			
			    <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>{{ @$report->get('قوات مسلحة')[0]->count ?? 0 }}</td>
              @php($totalCount += @$report->get('قوات مسلحة')[0]->count)

              <td>{{ @$report->get('شرطة موحدة')[0]->count ?? 0 }}</td>
              @php($totalCount += @$report->get('شرطة موحدة')[0]->count)

              <td>{{ @$report->get('جهاز الأمن')[0]->count ?? 0 }}</td>
              @php($totalCount += @$report->get('جهاز الأمن')[0]->count)

              <td>{{ @$report->get('قرارات')[0]->count ?? 0 }}</td>
              @php($totalCount +=  @$report->get('قرارات')[0]->count)

              <td>{{ @$report->get('شهداء الكرامة')[0]->count ?? 0 }}</td>
              @php($totalCount += @$report->get('شهداء الكرامة')[0]->count)
              <td>{{ $totalCount }}</td>
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                {{ isset($report->get('قوات مسلحة')[0]->count) ? round(($report->get('قوات مسلحة')[0]->count / $totalCount) * 100, 1) . '%' : 0}}
              </td>
              <td>
                {{ isset($report->get('شرطة موحدة')[0]->count) ? round(($report->get('شرطة موحدة')[0]->count / $totalCount) * 100, 1).'%' : 0}} 
              </td>
              <td>
                {{ isset($report->get('جهاز الأمن')[0]->count) ? round(($report->get('جهاز الأمن')[0]->count / $totalCount) * 100, 1).'%' : 0}} 
              </td>
              <td>
                {{ isset($report->get('قرارات')[0]->count) ? round(($report->get('قرارات')[0]->count / $totalCount) * 100, 1).'%' : 0}} 
              </td>
              <td>
                {{ isset($report->get('شهداء الكرامة')[0]->count) ?  round(($report->get('شهداء الكرامة')[0]->count / $totalCount) * 100, 1).'%':0 }} 
              </td>
              <td>
                @if ($totalCount > 0)
                  100%
                @else
                  0%
                @endif
              </td>
            </tr>
            <caption class="text-primary">
              @if(request()->query('sector') != 'all')
                {{ request()->query('sector') }}
              @else
              كل القطاعات
              @endif

              @if( request()->query('locality') == 'all') 
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

  @include('components.footer')