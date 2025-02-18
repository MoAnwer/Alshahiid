@include('components.header', ['page_title' => 'تقارير مصابي العمليات'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تقارير مصابي العمليات</h4>
            <button class="mx-4 btn  btn-primary active" onclick="printTable()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
        </div>

        <hr>
        {{-- search form --}}
        <x-search-form />
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
            @php
            $totalNeed = 0;
            $totalDone = 0;
            $totalBudget = 0;
            $totalBudgetFromOrg = 0;
            $totalBudgetOutOfOrg = 0;
            $totalMoney = 0;
            @endphp
           <tr>
              <td>إعانة عامة</td>
              <td>
                @if (!@is_null($report->get('إعانة عامة')) && !@is_null($report->get('إعانة عامة')['مطلوب']))
                  {{ @$report->get('إعانة عامة')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('إعانة عامة')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('إعانة عامة')) && @isset($report->get('إعانة عامة')['منفذ']))
                  {{ @$report->get('إعانة عامة')['منفذ'][0]->count }}
                   @php($totalDone +=  $report->get('إعانة عامة')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('إعانة عامة')) && !@is_null($report->get('إعانة عامة')['مطلوب']) && !@is_null($report->get('إعانة عامة')['منفذ'])
                  && $report->get('إعانة عامة')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('إعانة عامة')['منفذ'][0]->count  /  $report->get('إعانة عامة')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('إعانة عامة')['منفذ'][0]->budget ?? 0) + (@$report->get('إعانة عامة')['مطلوب'][0]->budget ?? 0)) }}
                   @php($totalBudget += (@$report->get('إعانة عامة')['منفذ'][0]->budget ?? 0) + (@$report->get('إعانة عامة')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('إعانة عامة')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('إعانة عامة')['مطلوب'][0]->budget_from_org ?? 0)) }}
                   @php($totalBudgetFromOrg += (@$report->get('إعانة عامة')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('إعانة عامة')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('إعانة عامة')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('إعانة عامة')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('إعانة عامة')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('إعانة عامة')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('إعانة عامة')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('إعانة عامة')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('إعانة عامة')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('إعانة عامة')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                  @php($totalMoney += (@$report->get('إعانة عامة')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('إعانة عامة')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('إعانة عامة')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('إعانة عامة')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>سكن</td>
              <td>
                @if (!@is_null($report->get('سكن')) && !@is_null($report->get('سكن')['مطلوب']))
                  {{ $report->get('سكن')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('سكن')['مطلوب'][0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('سكن')) && @isset($report->get('سكن')['منفذ']))
                  {{ @$report->get('سكن')['منفذ'][0]->count }}
                  @php($totalDone += @$report->get('سكن')['منفذ'][0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('سكن')) && !@is_null($report->get('سكن')['مطلوب']) && !@is_null($report->get('سكن')['منفذ'])
                  && $report->get('سكن')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('سكن')['منفذ'][0]->count  /  $report->get('سكن')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('سكن')['منفذ'][0]->budget ?? 0) + (@$report->get('سكن')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('سكن')['منفذ'][0]->budget ?? 0) + (@$report->get('سكن')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('سكن')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('سكن')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('سكن')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('سكن')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('سكن')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('سكن')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('سكن')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('سكن')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('سكن')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('سكن')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('سكن')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('سكن')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                  @php($totalMoney +=  (@$report->get('سكن')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('سكن')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('سكن')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('سكن')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>مشروع إنتاجي</td>
              <td>
                @if (!@is_null($report->get('مشروع إنتاجي')) && !@is_null($report->get('مشروع إنتاجي')['مطلوب']))
                  {{ $report->get('مشروع إنتاجي')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('مشروع إنتاجي')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('مشروع إنتاجي')) && @isset($report->get('مشروع إنتاجي')['منفذ']))
                  {{ @$report->get('مشروع إنتاجي')['منفذ'][0]->count }}
                  @php($totalDone += @$report->get('مشروع إنتاجي')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('مشروع إنتاجي')) && !@is_null($report->get('مشروع إنتاجي')['مطلوب']) && !@is_null($report->get('مشروع إنتاجي')['منفذ'])
                  && $report->get('مشروع إنتاجي')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('مشروع إنتاجي')['منفذ'][0]->count  /  $report->get('مشروع إنتاجي')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('مشروع إنتاجي')['منفذ'][0]->budget ?? 0) + (@$report->get('مشروع إنتاجي')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('مشروع إنتاجي')['منفذ'][0]->budget ?? 0) + (@$report->get('مشروع إنتاجي')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('مشروع إنتاجي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('مشروع إنتاجي')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('مشروع إنتاجي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('مشروع إنتاجي')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('مشروع إنتاجي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('مشروع إنتاجي')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('مشروع إنتاجي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('مشروع إنتاجي')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('مشروع إنتاجي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('مشروع إنتاجي')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('مشروع إنتاجي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('مشروع إنتاجي')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                  @php($totalMoney += (@$report->get('مشروع إنتاجي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('مشروع إنتاجي')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('مشروع إنتاجي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('مشروع إنتاجي')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
 
           <tr>
              <td>طرف صناعي</td>
              <td>
                @if (!@is_null($report->get('طرف صناعي')) && !@is_null($report->get('طرف صناعي')['مطلوب']))
                  {{ $report->get('طرف صناعي')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('طرف صناعي')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('طرف صناعي')) && @isset($report->get('طرف صناعي')['منفذ']))
                  {{ @$report->get('طرف صناعي')['منفذ'][0]->count }}
                  @php($totalDone += $report->get('طرف صناعي')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('طرف صناعي')) && !@is_null($report->get('طرف صناعي')['مطلوب']) && !@is_null($report->get('طرف صناعي')['منفذ'])
                  && $report->get('طرف صناعي')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('طرف صناعي')['منفذ'][0]->count  /  $report->get('طرف صناعي')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('طرف صناعي')['منفذ'][0]->budget ?? 0) + (@$report->get('طرف صناعي')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('طرف صناعي')['منفذ'][0]->budget ?? 0) + (@$report->get('طرف صناعي')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('طرف صناعي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('طرف صناعي')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('طرف صناعي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('طرف صناعي')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('طرف صناعي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('طرف صناعي')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('طرف صناعي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('طرف صناعي')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{
                    (@$report->get('طرف صناعي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('طرف صناعي')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('طرف صناعي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('طرف صناعي')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                  @php($totalMoney += (@$report->get('طرف صناعي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('طرف صناعي')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('طرف صناعي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('طرف صناعي')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>وسيلة حركة</td>
              <td>
                @if (!@is_null($report->get('وسيلة حركة')) && !@is_null($report->get('وسيلة حركة')['مطلوب']))
                  {{ $report->get('وسيلة حركة')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('وسيلة حركة')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('وسيلة حركة')) && @isset($report->get('وسيلة حركة')['منفذ']))
                  {{ @$report->get('وسيلة حركة')['منفذ'][0]->count }}
                  @php($totalDone += @$report->get('وسيلة حركة')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('وسيلة حركة')) && !@is_null($report->get('وسيلة حركة')['مطلوب']) && !@is_null($report->get('وسيلة حركة')['منفذ'])
                  && $report->get('وسيلة حركة')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('وسيلة حركة')['منفذ'][0]->count  /  $report->get('وسيلة حركة')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('وسيلة حركة')['منفذ'][0]->budget ?? 0) + (@$report->get('وسيلة حركة')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('وسيلة حركة')['منفذ'][0]->budget ?? 0) + (@$report->get('وسيلة حركة')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('وسيلة حركة')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('وسيلة حركة')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('وسيلة حركة')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('وسيلة حركة')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('وسيلة حركة')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('وسيلة حركة')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('وسيلة حركة')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('وسيلة حركة')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('وسيلة حركة')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('وسيلة حركة')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('وسيلة حركة')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('وسيلة حركة')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                  @php($totalMoney += (@$report->get('وسيلة حركة')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('وسيلة حركة')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('وسيلة حركة')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('وسيلة حركة')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>علاج</td>
              <td>
                @if (!@is_null($report->get('علاج')) && !@is_null($report->get('علاج')['مطلوب']))
                  {{ $report->get('علاج')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('علاج')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('علاج')) && @isset($report->get('علاج')['منفذ']))
                  {{ @$report->get('علاج')['منفذ'][0]->count }}
                  @php($totalDone += $report->get('علاج')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('علاج')) && !@is_null($report->get('علاج')['مطلوب']) && !@is_null($report->get('علاج')['منفذ'])
                  && $report->get('علاج')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('علاج')['منفذ'][0]->count  /  $report->get('علاج')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('علاج')['منفذ'][0]->budget ?? 0) + (@$report->get('علاج')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('علاج')['منفذ'][0]->budget ?? 0) + (@$report->get('علاج')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('علاج')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('علاج')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('علاج')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('علاج')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('علاج')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('علاج')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('علاج')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('علاج')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('علاج')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('علاج')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('علاج')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('علاج')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                  @php($totalMoney += (@$report->get('علاج')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('علاج')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('علاج')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('علاج')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>تأهيل مهني و معنوي</td>
              <td>
                @if (!@is_null($report->get('تأهيل مهني و معنوي')) && !@is_null($report->get('تأهيل مهني و معنوي')['مطلوب']))
                  {{ $report->get('تأهيل مهني و معنوي')['مطلوب'][0]->count }}
                   @php($totalNeed += $report->get('تأهيل مهني و معنوي')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('تأهيل مهني و معنوي')) && @isset($report->get('تأهيل مهني و معنوي')['منفذ']))
                  {{ @$report->get('تأهيل مهني و معنوي')['منفذ'][0]->count }}
                  @php($totalDone += @$report->get('تأهيل مهني و معنوي')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('تأهيل مهني و معنوي')) && !@is_null($report->get('تأهيل مهني و معنوي')['مطلوب']) && !@is_null($report->get('تأهيل مهني و معنوي')['منفذ'])
                  && $report->get('تأهيل مهني و معنوي')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('تأهيل مهني و معنوي')['منفذ'][0]->count  /  $report->get('تأهيل مهني و معنوي')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                {{ number_format((@$report->get('تأهيل مهني و معنوي')['منفذ'][0]->budget ?? 0) + (@$report->get('تأهيل مهني و معنوي')['مطلوب'][0]->budget ?? 0)) }}
                @php($totalBudget += (@$report->get('تأهيل مهني و معنوي')['منفذ'][0]->budget ?? 0) + (@$report->get('تأهيل مهني و معنوي')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                {{ number_format((@$report->get('تأهيل مهني و معنوي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تأهيل مهني و معنوي')['مطلوب'][0]->budget_from_org ?? 0)) }}
                 @php($totalBudgetFromOrg += (@$report->get('تأهيل مهني و معنوي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تأهيل مهني و معنوي')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('تأهيل مهني و معنوي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تأهيل مهني و معنوي')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                   @php($totalBudgetOutOfOrg += (@$report->get('تأهيل مهني و معنوي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تأهيل مهني و معنوي')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('تأهيل مهني و معنوي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تأهيل مهني و معنوي')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('تأهيل مهني و معنوي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تأهيل مهني و معنوي')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                   @php($totalMoney += (@$report->get('تأهيل مهني و معنوي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تأهيل مهني و معنوي')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('تأهيل مهني و معنوي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تأهيل مهني و معنوي')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>الإجمالي</td>
              <td>{{ $totalNeed }}</td>
              <td>{{ $totalDone }}</td>
              <td>%{{ $totalDone > 0 && $totalNeed > 0  ? round(($totalDone / $totalNeed) * 100, 1) : 0 }}</td>
              <td>{{ number_format($totalBudget) }}</td>
              <td>{{ number_format($totalBudgetFromOrg) }}</td>
              <td>{{ number_format($totalBudgetOutOfOrg) }}</td>
              <td>{{ number_format($totalMoney) }}</td>
           </tr>

           <caption>
            مصابي العمليات
            
              @if(request()->query('sector') != 'all' && !is_null(request()->query('sector')))
                {{ request()->query('sector') }}
              @else
              كل القطاعات
              @endif

              @if( request()->query('locality') == 'all' && !is_null(request()->query('locality'))) 
                كل المحليات
              @else
                 {{ request()->query('locality')  }}
              @endif

           </caption>

			    </x-slot:body>

		    </x-table>

      </div>
    </div>

  @include('components.footer')