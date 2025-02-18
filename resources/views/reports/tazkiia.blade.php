@include('components.header', ['page_title' => 'تقارير التزكية الروحية'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تقارير التزكية الروحية</h4>
          <button class="mx-4 btn  btn-primary active" onclick="printTable()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
        </div>

        <x-search-form />
        
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
            @php
            $totalNeed = 0;
            $totalDone = 0;
            $totalBudget = 0;
            $totalBudgetFromOrg = 0;
            $totalBudgetOutOfOrg = 0;
            $totalMoney = 0;
            @endphp
           <tr>
              <td>حلقات</td>
              <td>
                @if (!@is_null($report->get('sessions')) && !@is_null($report->get('sessions')['مطلوب']))
                  {{ @$report->get('sessions')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('sessions')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('sessions')) && @isset($report->get('sessions')['منفذ']))
                  {{ @$report->get('sessions')['منفذ'][0]->count }}
                   @php($totalDone +=  $report->get('sessions')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('sessions')) && !@is_null($report->get('sessions')['مطلوب']) && !@is_null($report->get('sessions')['منفذ'])
                  && $report->get('sessions')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('sessions')['منفذ'][0]->count  /  $report->get('sessions')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('sessions')['منفذ'][0]->budget ?? 0) + (@$report->get('sessions')['مطلوب'][0]->budget ?? 0)) }}
                   @php($totalBudget += (@$report->get('sessions')['منفذ'][0]->budget ?? 0) + (@$report->get('sessions')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('sessions')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('sessions')['مطلوب'][0]->budget_from_org ?? 0)) }}
                   @php($totalBudgetFromOrg += (@$report->get('sessions')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('sessions')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('sessions')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('sessions')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('sessions')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('sessions')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    number_format((@$report->get('sessions')['منفذ'][0]->totalBudget ?? 0) + (@$report->get('sessions')['مطلوب'][0]->totalBudget ?? 0))
                  }}
                    @php($totalMoney += (@$report->get('sessions')['منفذ'][0]->totalBudget ?? 0) + (@$report->get('sessions')['مطلوب'][0]->totalBudget ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>معسكرات تربوية</td>
              <td>
                @if (!@is_null($report->get('camps')) && !@is_null($report->get('camps')['مطلوب']))
                  {{ $report->get('camps')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('camps')['مطلوب'][0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('camps')) && @isset($report->get('camps')['منفذ']))
                  {{ @$report->get('camps')['منفذ'][0]->count }}
                  @php($totalDone += @$report->get('camps')['منفذ'][0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('camps')) && !@is_null($report->get('camps')['مطلوب']) && !@is_null($report->get('camps')['منفذ'])
                  && $report->get('camps')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('camps')['منفذ'][0]->count  /  $report->get('camps')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('camps')['منفذ'][0]->budget ?? 0) + (@$report->get('camps')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('camps')['منفذ'][0]->budget ?? 0) + (@$report->get('camps')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('camps')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('camps')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('camps')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('camps')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('camps')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('camps')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('camps')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('camps')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('camps')['منفذ'][0]->totalBudget ?? 0) + (@$report->get('camps')['مطلوب'][0]->totalBudget ?? 0)
                  }}
                    @php($totalMoney += (@$report->get('camps')['منفذ'][0]->totalBudget ?? 0) + (@$report->get('camps')['مطلوب'][0]->totalBudget ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>ندوات و محاضرات</td>
              <td>
                @if (!@is_null($report->get('lectures')) && !@is_null($report->get('lectures')['مطلوب']))
                  {{ $report->get('lectures')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('lectures')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('lectures')) && @isset($report->get('lectures')['منفذ']))
                  {{ @$report->get('lectures')['منفذ'][0]->count }}
                  @php($totalDone += @$report->get('lectures')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('lectures')) && !@is_null($report->get('lectures')['مطلوب']) && !@is_null($report->get('lectures')['منفذ'])
                  && $report->get('lectures')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('lectures')['منفذ'][0]->count  /  $report->get('lectures')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('lectures')['منفذ'][0]->budget ?? 0) + (@$report->get('lectures')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('lectures')['منفذ'][0]->budget ?? 0) + (@$report->get('lectures')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('lectures')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('lectures')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('lectures')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('lectures')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('lectures')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('lectures')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('lectures')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('lectures')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>{{ number_format((@$report->get('lectures')['منفذ'][0]->totalBudget ?? 0) + (@$report->get('lectures')['مطلوب'][0]->totalBudget ?? 0))}}
                  @php($totalMoney += (@$report->get('lectures')['منفذ'][0]->totalBudget ?? 0) + (@$report->get('lectures')['مطلوب'][0]->totalBudget ?? 0))
              </td>
           </tr>
 
           <tr>
              <td>حج و عمرة</td>
              <td>
                @if (!@is_null($report->get('hags')) && !@is_null($report->get('hags')['مطلوب']))
                  {{ $report->get('hags')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('hags')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('hags')) && @isset($report->get('hags')['منفذ']))
                  {{ @$report->get('hags')['منفذ'][0]->count }}
                  @php($totalDone += $report->get('hags')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('hags')) && !@is_null($report->get('hags')['مطلوب']) && !@is_null($report->get('hags')['منفذ'])
                  && $report->get('hags')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('hags')['منفذ'][0]->count  /  $report->get('hags')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('hags')['منفذ'][0]->budget ?? 0) + (@$report->get('hags')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('hags')['منفذ'][0]->budget ?? 0) + (@$report->get('hags')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('hags')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('hags')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('hags')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('hags')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('hags')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('hags')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('hags')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('hags')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{
                    number_format((@$report->get('hags')['منفذ'][0]->totalBudget ?? 0) + (@$report->get('hags')['مطلوب'][0]->totalBudget ?? 0))
                  }}
                  @php($totalMoney += (@$report->get('hags')['منفذ'][0]->totalBudget ?? 0) + (@$report->get('hags')['مطلوب'][0]->totalBudget ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>توثيق سير الشهداء</td>
              <td>
                @if (!@is_null($report->get('martyrsDocs')) && !@is_null($report->get('martyrsDocs')['مطلوب']))
                  {{ $report->get('martyrsDocs')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('martyrsDocs')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('martyrsDocs')) && @isset($report->get('martyrsDocs')['منفذ']))
                  {{ @$report->get('martyrsDocs')['منفذ'][0]->count }}
                  @php($totalDone += @$report->get('martyrsDocs')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('martyrsDocs')) && !@is_null($report->get('martyrsDocs')['مطلوب']) && !@is_null($report->get('martyrsDocs')['منفذ'])
                  && $report->get('martyrsDocs')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('martyrsDocs')['منفذ'][0]->count  /  $report->get('martyrsDocs')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('martyrsDocs')['منفذ'][0]->budget ?? 0) + (@$report->get('martyrsDocs')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('martyrsDocs')['منفذ'][0]->budget ?? 0) + (@$report->get('martyrsDocs')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('martyrsDocs')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('martyrsDocs')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('martyrsDocs')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('martyrsDocs')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('martyrsDocs')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('martyrsDocs')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('martyrsDocs')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('martyrsDocs')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    number_format((@$report->get('martyrsDocs')['منفذ'][0]->totalBudget ?? 0) + (@$report->get('martyrsDocs')['مطلوب'][0]->totalBudget ?? 0))
                  }}
                    @php($totalMoney += (@$report->get('martyrsDocs')['منفذ'][0]->totalBudget ?? 0) + (@$report->get('martyrsDocs')['مطلوب'][0]->totalBudget ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>التواصل مع اسر الشهداء</td>
              <td>
                @if (!@is_null($report->get('martyrCom')) && !@is_null($report->get('martyrCom')['مطلوب']))
                  {{ $report->get('martyrCom')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('martyrCom')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('martyrCom')) && @isset($report->get('martyrCom')['منفذ']))
                  {{ @$report->get('martyrCom')['منفذ'][0]->count }}
                  @php($totalDone += $report->get('martyrCom')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('martyrCom')) && !@is_null($report->get('martyrCom')['مطلوب']) && !@is_null($report->get('martyrCom')['منفذ'])
                  && $report->get('martyrCom')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('martyrCom')['منفذ'][0]->count  /  $report->get('martyrCom')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('martyrCom')['منفذ'][0]->budget ?? 0) + (@$report->get('martyrCom')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('martyrCom')['منفذ'][0]->budget ?? 0) + (@$report->get('martyrCom')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('martyrCom')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('martyrCom')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('martyrCom')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('martyrCom')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('martyrCom')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('martyrCom')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('martyrCom')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('martyrCom')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    number_format((@$report->get('martyrCom')['منفذ'][0]->totalBudget ?? 0) + (@$report->get('martyrCom')['مطلوب'][0]->totalBudget ?? 0))
                  }}
                  @php($totalMoney += (@$report->get('martyrCom')['منفذ'][0]->totalBudget ?? 0) + (@$report->get('martyrCom')['مطلوب'][0]->totalBudget ?? 0))
              </td>
           </tr>

           <tr>
              <td><b>الإجمالي</b></td>
              <td>{{ $totalNeed }}</td>
              <td>{{ $totalDone }}</td>
              <td>%{{ $totalDone > 0  ? round(($totalDone / $totalNeed) * 100, 1) : 0 }}</td>
              <td>{{ number_format($totalBudget) }}</td>
              <td>{{ number_format($totalBudgetFromOrg) }}</td>
              <td>{{ number_format($totalBudgetOutOfOrg) }}</td>
              <td>{{ number_format($totalMoney) }}</td>
           </tr>

           <caption>
              تقرير التزكية الروحية 
               @if(request()->query('sector') == 'all' || is_null(request()->query('sector')))
               كل القطاعات
              @else
                {{ request()->query('sector') }}
              @endif

              @if(request()->query('locality') == 'all')
               كل المحليات
              @else
                {{ request()->query('locality') }}
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