@include('components.header', ['page_title' => 'تقرير الكفالات'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تقرير الكفالات</h4>
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
                <td>مجتمعية</td>
                <td>
                  @if($report->has('مجتمعية'))
                    {{ (@$report->get('مجتمعية')['مطلوب'][0]->count ?? 0) }}
                    @php($totalNeed += (@$report->get('مجتمعية')['مطلوب'][0]->count ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('مجتمعية'))
                    {{ (@$report->get('مجتمعية')['منفذ'][0]->count ?? 0) }}
                     @php($totalDone += (@$report->get('مجتمعية')['منفذ'][0]->count ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('مجتمعية') && @!is_null($report->get('مجتمعية')['منفذ']))
                    {{ round(((@$report->get('مجتمعية')['منفذ'][0]->count) / (@$report->get('مجتمعية')['مطلوب'][0]->count ?? 1)) * 100, 1) . '%' }}
                  @else
                    0%
                  @endif
                </td>
                <td>
                  @if($report->has('مجتمعية'))
                    {{ number_format((@$report->get('مجتمعية')['مطلوب'][0]->budget ?? 0) + (@$report->get('مجتمعية')['منفذ'][0]->budget ?? 0) ) }}
                     @php($totalBudget += (@$report->get('مجتمعية')['مطلوب'][0]->budget ?? 0) + (@$report->get('مجتمعية')['منفذ'][0]->budget ?? 0) )
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('مجتمعية'))
                    {{ number_format((@$report->get('مجتمعية')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('مجتمعية')['منفذ'][0]->budget_from_org ?? 0))}}
                    @php($totalBudgetFromOrg += (@$report->get('مجتمعية')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('مجتمعية')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('مجتمعية'))
                    {{ number_format((@$report->get('مجتمعية')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('مجتمعية')['منفذ'][0]->budget_out_of_org ?? 0))}}
                    @php($totalBudgetOutOfOrg += (@$report->get('مجتمعية')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('مجتمعية')['منفذ'][0]->budget_out_of_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('مجتمعية'))
                    {{ number_format((@$report->get('مجتمعية')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('مجتمعية')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('مجتمعية')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('مجتمعية')['منفذ'][0]->budget_from_org ?? 0))
                    }}
                    @php($totalMoney += (@$report->get('مجتمعية')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('مجتمعية')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('مجتمعية')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('مجتمعية')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
              </tr>
             <tr>
                <td>مؤسسية</td>
                <td>
                  @if($report->has('مؤسسية'))
                    {{ (@$report->get('مؤسسية')['مطلوب'][0]->count ?? 0) }}
                    @php($totalNeed += (@$report->get('مؤسسية')['مطلوب'][0]->count ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('مؤسسية'))
                    {{ (@$report->get('مؤسسية')['منفذ'][0]->count ?? 0) }}
                    @php($totalDone +=  (@$report->get('مؤسسية')['منفذ'][0]->count ?? 0) )
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('مؤسسية') && @!is_null($report->get('مؤسسية')['منفذ']))
                    {{ round(((@$report->get('مؤسسية')['منفذ'][0]->count) / (@$report->get('مؤسسية')['مطلوب'][0]->count ?? 1)) * 100, 1) . '%' }}
                  @else
                    0%
                  @endif
                </td>
                <td>
                  @if($report->has('مؤسسية'))
                    {{ number_format((@$report->get('مؤسسية')['مطلوب'][0]->budget ?? 0) + (@$report->get('مؤسسية')['منفذ'][0]->budget ?? 0)) }}
                    @php($totalBudget += (@$report->get('مؤسسية')['مطلوب'][0]->budget ?? 0) + (@$report->get('مؤسسية')['منفذ'][0]->budget ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('مؤسسية'))
                    {{ number_format((@$report->get('مؤسسية')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('مؤسسية')['منفذ'][0]->budget_from_org ?? 0)) }}
                    @php($totalBudgetFromOrg += (@$report->get('مؤسسية')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('مؤسسية')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('مؤسسية'))
                    {{ number_format((@$report->get('مؤسسية')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('مؤسسية')['منفذ'][0]->budget_out_of_org ?? 0)) }}
                    @php($totalBudgetOutOfOrg += (@$report->get('مؤسسية')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('مؤسسية')['منفذ'][0]->budget_out_of_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('مؤسسية'))
                    {{ number_format((@$report->get('مؤسسية')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('مؤسسية')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('مؤسسية')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('مؤسسية')['منفذ'][0]->budget_from_org ?? 0))
                    }}
                    @php($totalMoney += (@$report->get('مؤسسية')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('مؤسسية')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('مؤسسية')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('مؤسسية')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
              </tr>

              <tr>
                <td>المنظمة</td>
                <td>
                  @if($report->has('المنظمة'))
                    {{ (@$report->get('المنظمة')['مطلوب'][0]->count ?? 0) }}
                    @php($totalNeed += (@$report->get('المنظمة')['مطلوب'][0]->count ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('المنظمة'))
                    {{ (@$report->get('المنظمة')['منفذ'][0]->count ?? 0) }}
                    @php($totalDone += (@$report->get('المنظمة')['منفذ'][0]->count ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('المنظمة') && @!is_null($report->get('المنظمة')['منفذ']))
                    {{ round(((@$report->get('المنظمة')['منفذ'][0]->count) / (@$report->get('المنظمة')['مطلوب'][0]->count ?? 1)) * 100, 1) . '%' }}
                  @else
                    0%
                  @endif
                </td>
                <td>
                  @if($report->has('المنظمة'))
                    {{ number_format((@$report->get('المنظمة')['مطلوب'][0]->budget ?? 0) + (@$report->get('المنظمة')['منفذ'][0]->budget ?? 0)) }}
                    @php($totalBudget += (@$report->get('المنظمة')['مطلوب'][0]->budget ?? 0) + (@$report->get('المنظمة')['منفذ'][0]->budget ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('المنظمة'))
                    {{ number_format((@$report->get('المنظمة')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('المنظمة')['منفذ'][0]->budget_from_org ?? 0))}}
                    @php($totalBudgetFromOrg += (@$report->get('المنظمة')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('المنظمة')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('المنظمة'))
                    {{ number_format((@$report->get('المنظمة')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('المنظمة')['منفذ'][0]->budget_out_of_org ?? 0)) }}
                    @php($totalBudgetOutOfOrg += (@$report->get('المنظمة')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('المنظمة')['منفذ'][0]->budget_out_of_org ?? 0))
                  @else
                    0
                  @endif
                </td>
                <td>
                  @if($report->has('المنظمة'))
                    {{ number_format((@$report->get('المنظمة')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('المنظمة')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('المنظمة')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('المنظمة')['منفذ'][0]->budget_from_org ?? 0))
                    }}
                    @php($totalMoney += (@$report->get('المنظمة')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report->get('المنظمة')['منفذ'][0]->budget_out_of_org ?? 0)
                      + (@$report->get('المنظمة')['مطلوب'][0]->budget_from_org ?? 0) + (@$report->get('المنظمة')['منفذ'][0]->budget_from_org ?? 0))
                  @else
                    0
                  @endif
                </td>
              </tr>

              
            <tr>
              <td>الاجمالي</td>
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