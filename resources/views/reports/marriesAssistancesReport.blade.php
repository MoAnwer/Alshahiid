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
        </div>
    
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

            <caption>
              @empty(!request()->query('sector'))
                {{ request()->query('sector') . ' - ' . request()->query('locality')}}
              @else
              كل القطاعات
              @endempty
            </caption>

            </x-slot:body>

          </x-table>
    </div>
  </div>

  @include('components.footer')