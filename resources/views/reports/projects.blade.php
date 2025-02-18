@include('components.header', ['page_title' => 'تقارير المشروعات'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4  mb-1">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تقارير المشروعات</h4>
          <button class="mx-4 btn  btn-primary active" onclick="printTable()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
        </div>
        <hr />

        {{-- search form --}}
          <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

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
              
              <div class="col-2">
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

              <div class="col-3">
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

        {{-- search form --}}
        
        
		      <x-table>
			     <x-slot:head>
              <th>نوع الخدمة</th>
              <th>مطلوب</th>
              <th>منفذ</th>
			        <th>النسبة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة</th>
              <th>الاجمالي الكلي</th>
            </x-slot:head>
			
			     <x-slot:body>
              <tr>
                <td>فردية جديدة</td>
                <td>{{ ($report->get('فردي')['مطلوب'][0]->count ?? 0) }}</td>
                <td>{{ ($report->get('فردي')['منفذ'][0]->count ?? 0) }}</td>
                <td>
                  @if(@$report->get('فردي')['منفذ'][0]->count > 0 && @$report->get('فردي')['مطلوب'][0]->count > 0) 
                    {{ round(($report->get('فردي')['منفذ'][0]->count / $report->get('فردي')['مطلوب'][0]->count) * 100, 1). '%'}}
                  @else 
                    0%
                  @endif
                </td>

                <td>{{ number_format(($report->get('فردي')['مطلوب'][0]->budget ?? 0) +  ($report->get('فردي')['منفذ'][0]->budget ?? 0)) }}</td>

                <td>{{ number_format(($report->get('فردي')['مطلوب'][0]->budget_from_org ?? 0)  +  ($report->get('فردي')['منفذ'][0]->budget_from_org ?? 0)) }}</td>

                <td>{{ number_format(($report->get('فردي')['مطلوب'][0]->budget_out_of_org ?? 0) +  ($report->get('فردي')['منفذ'][0]->budget_out_of_org ?? 0)) }}</td>

                <td>{{  number_format(($report->get('فردي')['مطلوب'][0]->totalMoney ?? 0) + ( $report->get('فردي')['منفذ'][0]->totalMoney ?? 0)) }} </td>

              </tr>
              <tr>
                <td>جماعية جديدة</td>
                <td>{{ ($report->get('جماعي')['مطلوب'][0]->count ?? 0) }}</td>
                <td>{{ ($report->get('جماعي')['منفذ'][0]->count ?? 0) }}</td>
                <td>
                  @if(@$report->get('جماعي')['منفذ'][0]->count > 0 && @$report->get('جماعي')['مطلوب'][0]->count > 0) 
                    {{ round(($report->get('جماعي')['منفذ'][0]->count / $report->get('جماعي')['مطلوب'][0]->count) * 100, 1). '%'}}
                  @else 
                    0%
                  @endif
                </td>

                <td>{{ number_format(($report->get('جماعي')['مطلوب'][0]->budget ?? 0) + ($report->get('جماعي')['منفذ'][0]->budget ?? 0)) }}</td>

                <td>{{ number_format(($report->get('جماعي')['مطلوب'][0]->budget_from_org ?? 0)  +  ($report->get('جماعي')['منفذ'][0]->budget_from_org ?? 0)) }}</td>

                <td>{{ number_format(($report->get('جماعي')['مطلوب'][0]->budget_out_of_org ?? 0) +  ($report->get('جماعي')['منفذ'][0]->budget_out_of_org ?? 0)) }}</td>

                <td>{{  number_format(($report->get('جماعي')['مطلوب'][0]->totalMoney ?? 0)  + ( $report->get('جماعي')['منفذ'][0]->totalMoney ?? 0)) }} </td>

              </tr>

              <tr>
                <td>الاجمالي</td>  
                <td>{{ ($report->get('فردي')['مطلوب'][0]->count ?? 0) + ($report->get('جماعي')['مطلوب'][0]->count ?? 0) }}</td>
                @php($totalNeed = ($report->get('فردي')['مطلوب'][0]->count ?? 0) + ($report->get('جماعي')['مطلوب'][0]->count ?? 0))

                <td>{{ ($report->get('فردي')['منفذ'][0]->count ?? 0) + ($report->get('جماعي')['منفذ'][0]->count ?? 0)}}</td>
                @php($totalDone = ($report->get('فردي')['منفذ'][0]->count ?? 0) + ($report->get('جماعي')['منفذ'][0]->count ?? 0))
                <td>
                  @if($totalDone > 0 && $totalNeed > 0) 
                    {{ round(($totalDone / $totalNeed) * 100, 2) . '%' }}
                  @else 
                    0%
                  @endif
               </td>
               <td>{{ number_format(($report->get('فردي')['مطلوب'][0]->budget ?? 0) +  ($report->get('فردي')['منفذ'][0]->budget ?? 0) + ($report->get('جماعي')['مطلوب'][0]->budget ?? 0) +  ($report->get('جماعي')['منفذ'][0]->budget ?? 0)) }}</td>

               <td>{{ number_format(($report->get('فردي')['مطلوب'][0]->budget_from_org ?? 0) +  ($report->get('فردي')['منفذ'][0]->budget_from_org ?? 0) + ($report->get('جماعي')['مطلوب'][0]->budget_from_org ?? 0) +  ($report->get('جماعي')['منفذ'][0]->budget_from_org ?? 0)) }}</td>

               <td>{{ number_format(($report->get('فردي')['مطلوب'][0]->budget_out_of_org ?? 0) +  ($report->get('فردي')['منفذ'][0]->budget_out_of_org ?? 0) + ($report->get('جماعي')['مطلوب'][0]->budget_out_of_org ?? 0) +  ($report->get('جماعي')['منفذ'][0]->budget_out_of_org ?? 0)) }}</td>

               <td>{{ number_format(($report->get('فردي')['مطلوب'][0]->totalMoney ?? 0) +  ($report->get('فردي')['منفذ'][0]->totalMoney ?? 0) + ($report->get('جماعي')['مطلوب'][0]->totalMoney ?? 0) +  ($report->get('جماعي')['منفذ'][0]->totalMoney ?? 0)) }}</td>

              </tr>

            <caption class="text-primary">
              تقرير المشروعات
               @if(request()->query('force') != 'all')
                {{ request()->query('force') }}
                @endif

              @if(request()->query('sector') != 'all' && !is_null(request()->query('sector')))
                {{ request()->query('sector') }}
              @else
              كل القطاعات
              @endif

              @if( request()->query('locality') == 'all' && !is_null(request()->query('locality'))) 
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

        {{-- <div dir="ltr">
          {{ 
            
          dd($report);
        }}</div> --}}
      </div>
    </div>

  @include('components.footer')