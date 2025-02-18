@include('components.header', ['page_title' => 'تقرير اعانات الزواج'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تقرير اعانات الزواج</h4>
             <button class="mx-4 btn  btn-primary active" onclick="printTable()">
              <i class="bi bi-printer ml-2"></i>
              طباعة 
            </button>
        </div>
        
        <hr>
    
        @php
          $totalNeed = 0;
          $totalDone = 0;
          $totalBudget = 0;
          $totalBudgetFromOrg = 0;
          $totalBudgetOutOfOrg = 0;
          $totalMoney = 0;
        @endphp


        <div class="search-form">

          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">

              <div class="col-1">
                <label>العلاقة :</label>
                <div class="form-group">
                  <select name="relation" class="form-select">
                    <option value="all"  @selected(request('relation') == "all")>الكل</option>
                    <option value="ابنة" @selected(request('relation') == 'ابنة')>ابنة</option>
                    <option value="اخ" @selected(request('relation') == 'اخ')>اخ</option>
                    <option value="اخت" @selected(request('relation') == 'اخت')>اخت</option>
                    <option value="زوجة" @selected(request('relation') == 'زوجة')>ارامل</option>
                  </select>
                </div>
              </div>

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
                          
                  <label>الشريحة</label>
                  
                  <div class="form-group">
                    <select class="form-select" name="category">
                       <option value="all">الكل</option>
                      @foreach(['أرملة و ابناء','أب و أم و أخوان و أخوات','أخوات','مكتفية'] as $category)
                        <option value="{{ $category }}" @selected(request('category') == $category)>{{ $category }}</option>
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

              <div class="col-1">
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

               <div class="col-1 mt-3 d-flex align-items-center">
                <button class="btn py-3 px-2 btn-primary active form-control ml-2" title="بحث">
                  <i class="bi bi-search"></i>
                </button>
                <a class="btn py-3 px-2 btn-success active form-control " title="القائمة" href="{{ request()->url() }}">
                  <i class="bi bi-menu-button"></i>
                </a>
              </div>

              </form>
            </div>
        </div>



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
            @if(is_null(request()->query('relation')) || (request()->query('relation') == 'all' || request()->query('relation') == 'زوجة' ))
              <tr>
                <td>أرامل</td>
                <td>
                  @if($report->has('زوجة'))
                    {{ (@$report->get('زوجة')['مطلوب'][0]->count ?? 0) }}
                    @php($totalNeed += (@$report->get('زوجة')['مطلوب'][0]->count ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('زوجة'))
                    {{ (@$report->get('زوجة')['منفذ'][0]->count ?? 0) }}
                     @php($totalDone += (@$report->get('زوجة')['منفذ'][0]->count ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('زوجة') && @!is_null($report->get('زوجة')['منفذ']))
                    {{ round(((@$report->get('زوجة')['منفذ'][0]->count) / (@$report->get('زوجة')['مطلوب'][0]->count ?? 1)) * 100, 1) . '%' }}
                  @else
                    0%
                  @endif
                </td>
                <td>
                  @if($report->has('زوجة'))
                    {{ number_format((@$report->get('زوجة')['مطلوب'][0]->budget ?? 0) + (@$report->get('زوجة')['منفذ'][0]->budget ?? 0) ) }}
                     @php($totalBudget += (@$report->get('زوجة')['مطلوب'][0]->budget ?? 0) + (@$report->get('زوجة')['منفذ'][0]->budget ?? 0) )
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('زوجة'))
                    {{ number_format((@$report->get('زوجة')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('زوجة')['منفذ'][0]->budget_from_org ?? 0))}}
                    @php($totalBudgetFromOrg += (@$report->get('زوجة')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('زوجة')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('زوجة'))
                    {{ number_format((@$report->get('زوجة')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('زوجة')['منفذ'][0]->budget_out_of_org ?? 0))}}
                    @php($totalBudgetOutOfOrg += (@$report->get('زوجة')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('زوجة')['منفذ'][0]->budget_out_of_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('زوجة'))
                    {{ number_format((@$report->get('زوجة')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('زوجة')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('زوجة')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('زوجة')['منفذ'][0]->budget_from_org ?? 0))
                    }}
                    @php($totalMoney += (@$report->get('زوجة')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('زوجة')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('زوجة')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('زوجة')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
              </tr>

            @endif

            @if(is_null(request()->query('relation')) || (request()->query('relation') == 'all' || request()->query('relation') == 'ابنة' ))
             <tr>
                <td>بنات</td>
                <td>
                  @if($report->has('ابنة'))
                    {{ (@$report->get('ابنة')['مطلوب'][0]->count ?? 0) }}
                    @php($totalNeed += (@$report->get('ابنة')['مطلوب'][0]->count ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('ابنة'))
                    {{ (@$report->get('ابنة')['منفذ'][0]->count ?? 0) }}
                    @php($totalDone +=  (@$report->get('ابنة')['منفذ'][0]->count ?? 0) )
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('ابنة') && @!is_null($report->get('ابنة')['منفذ']))
                    {{ round(((@$report->get('ابنة')['منفذ'][0]->count) / (@$report->get('ابنة')['مطلوب'][0]->count ?? 1)) * 100, 1) . '%' }}
                  @else
                    0%
                  @endif
                </td>
                <td>
                  @if($report->has('ابنة'))
                    {{ number_format((@$report->get('ابنة')['مطلوب'][0]->budget ?? 0) + (@$report->get('ابنة')['منفذ'][0]->budget ?? 0)) }}
                    @php($totalBudget += (@$report->get('ابنة')['مطلوب'][0]->budget ?? 0) + (@$report->get('ابنة')['منفذ'][0]->budget ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('ابنة'))
                    {{ number_format((@$report->get('ابنة')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('ابنة')['منفذ'][0]->budget_from_org ?? 0)) }}
                    @php($totalBudgetFromOrg += (@$report->get('ابنة')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('ابنة')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('ابنة'))
                    {{ number_format((@$report->get('ابنة')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('ابنة')['منفذ'][0]->budget_out_of_org ?? 0)) }}
                    @php($totalBudgetOutOfOrg += (@$report->get('ابنة')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('ابنة')['منفذ'][0]->budget_out_of_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('ابنة'))
                    {{ number_format((@$report->get('ابنة')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('ابنة')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('ابنة')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('ابنة')['منفذ'][0]->budget_from_org ?? 0))
                    }}
                    @php($totalMoney += (@$report->get('ابنة')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('ابنة')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('ابنة')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('ابنة')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
              </tr>
              @endif 

              @if(is_null(request()->query('relation')) || (request()->query('relation') == 'all' || request()->query('relation') == 'اخت' ))
              <tr>
                <td>اخوات</td>
                <td>
                  @if($report->has('اخت'))
                    {{ (@$report->get('اخت')['مطلوب'][0]->count ?? 0) }}
                    @php($totalNeed += (@$report->get('اخت')['مطلوب'][0]->count ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('اخت'))
                    {{ (@$report->get('اخت')['منفذ'][0]->count ?? 0) }}
                    @php($totalDone += (@$report->get('اخت')['منفذ'][0]->count ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('اخت') && @!is_null($report->get('اخت')['منفذ']))
                    {{ round(((@$report->get('اخت')['منفذ'][0]->count) / (@$report->get('اخت')['مطلوب'][0]->count ?? 1)) * 100, 1) . '%' }}
                  @else
                    0%
                  @endif
                </td>
                <td>
                  @if($report->has('اخت'))
                    {{ number_format((@$report->get('اخت')['مطلوب'][0]->budget ?? 0) + (@$report->get('اخت')['منفذ'][0]->budget ?? 0)) }}
                    @php($totalBudget += (@$report->get('اخت')['مطلوب'][0]->budget ?? 0) + (@$report->get('اخت')['منفذ'][0]->budget ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('اخت'))
                    {{ number_format((@$report->get('اخت')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('اخت')['منفذ'][0]->budget_from_org ?? 0))}}
                    @php($totalBudgetFromOrg += (@$report->get('اخت')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('اخت')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('اخت'))
                    {{ number_format((@$report->get('اخت')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('اخت')['منفذ'][0]->budget_out_of_org ?? 0)) }}
                    @php($totalBudgetOutOfOrg += (@$report->get('اخت')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('اخت')['منفذ'][0]->budget_out_of_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('اخت'))
                    {{ number_format((@$report->get('اخت')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('اخت')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('اخت')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('اخت')['منفذ'][0]->budget_from_org ?? 0))
                    }}
                    @php($totalMoney += (@$report->get('اخت')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('اخت')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('اخت')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('اخت')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
              </tr>
              

              @endif


              @if(is_null(request()->query('relation')) || (request()->query('relation') == 'all' || request()->query('relation') == 'اخ' ))
              <tr>
                <td>اخرى</td>
                <td>
                  @if($report->has('اخ'))
                    {{ (@$report->get('اخ')['مطلوب'][0]->count ?? 0) }}
                    @php($totalNeed += (@$report->get('اخ')['مطلوب'][0]->count ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('اخ'))
                    {{ (@$report->get('اخ')['منفذ'][0]->count ?? 0) }}
                    @php($totalDone += (@$report->get('اخ')['منفذ'][0]->count ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('اخ') && @!is_null($report->get('اخ')['منفذ']))
                    {{ round(((@$report->get('اخ')['منفذ'][0]->count) / (@$report->get('اخ')['مطلوب'][0]->count ?? 1)) * 100, 1) . '%' }}
                  @else
                    0%
                  @endif
                </td>
                <td>
                  @if($report->has('اخ'))
                    {{ number_format((@$report->get('اخ')['مطلوب'][0]->budget ?? 0) + (@$report->get('اخ')['منفذ'][0]->budget ?? 0)) }}
                    @php($totalBudget += (@$report->get('اخ')['مطلوب'][0]->budget ?? 0) + (@$report->get('اخ')['منفذ'][0]->budget ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('اخ'))
                    {{ number_format((@$report->get('اخ')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('اخ')['منفذ'][0]->budget_from_org ?? 0))}}
                    @php($totalBudgetFromOrg += (@$report->get('اخ')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('اخ')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('اخ'))
                    {{ number_format((@$report->get('اخ')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('اخ')['منفذ'][0]->budget_out_of_org ?? 0)) }}
                    @php($totalBudgetOutOfOrg += (@$report->get('اخ')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('اخ')['منفذ'][0]->budget_out_of_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('اخ'))
                    {{ number_format((@$report->get('اخ')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('اخ')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('اخ')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('اخ')['منفذ'][0]->budget_from_org ?? 0))
                    }}
                    @php($totalMoney += (@$report->get('اخ')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('اخ')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('اخ')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('اخ')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
              </tr>

              @endif
              
            <tr>
              <td>
                <b>الاجمالي</b>
              </td>
              <td>{{ $totalNeed }}</td>
              <td>{{ $totalDone }}</td>
              <td>
                @if($totalDone > 0 && $totalNeed > 0)
                  {{ round(($totalDone / $totalNeed) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>
              <td>{{ number_format($totalBudget) }}</td>
              <td>{{ number_format($totalBudgetFromOrg) }}</td>
              <td>{{ number_format($totalBudgetOutOfOrg) }}</td>
              <td>{{ number_format($totalMoney) }}</td>
            </tr>

            <caption class="text-primary">
              اعانات الزواج 
              
             @if(request()->query('relation') != 'all')
                 {{ request()->query('relation') == "زوجة" ? 'ارامل' : request()->query('relation') }}
              @endif
                -
             @if(request()->query('force') != 'all')
                {{ request()->query('force') }}
              @endif

              @if(request()->query('category') != 'all')
                {{ request()->query('category') }}
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

  @include('components.footer')