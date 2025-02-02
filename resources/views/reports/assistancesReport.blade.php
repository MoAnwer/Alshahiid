@include('components.header', ['page_title' => 'تقارير المساعدات'])
 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تقارير المساعدات</h4>
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
        </div> {{-- search form --}}

        <x-table>
          <x-slot:head>
            <th>نوع الخدمة</th>
            <th>المطلوب</th>
            <th>المنفذ</th>
            <th>النسبة</th>
            <th>التقديري</th>
            <th>من داخل المنظمة</th>
            <th>من خارج المنظمة</th>
            <th>الاجمالي</th>
          </x-slot:head>
			
			    <x-slot:body>
            <tr>
              <td>افطار الصائم</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['افطار الصائم']))
                    {{ $report->get('مطلوب')['افطار الصائم'][0]->count }}
                    @php($totalNeed += $report->get('مطلوب')['افطار الصائم'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['افطار الصائم']))
                    {{ $report->get('منفذ')['افطار الصائم'][0]->count }}
                    @php($totalDone += $report->get('منفذ')['افطار الصائم'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['افطار الصائم']) && isset($report->get('مطلوب')['افطار الصائم']))
                    @if($report->get('منفذ')['افطار الصائم'][0]->count !== 0 &&  $report->get('مطلوب')['افطار الصائم'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['افطار الصائم'][0]->count / $report->get('مطلوب')['افطار الصائم'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

              <td>
                {{ (@$report->get('منفذ')['افطار الصائم'][0]->budget ?? 0) + (@$report->get('مطلوب')['افطار الصائم'][0]->budget ?? 0) }}
                @php($totalBudget  += (@$report->get('منفذ')['افطار الصائم'][0]->budget ?? 0) + (@$report->get('مطلوب')['افطار الصائم'][0]->budget ?? 0))
              </td>

              <td>
                  {{ (@$report->get('منفذ')['افطار الصائم'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['افطار الصائم'][0]->budget_from_org ?? 0) }}
                  @php($totalBudgetFromOrg += (@$report->get('منفذ')['افطار الصائم'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['افطار الصائم'][0]->budget_from_org ?? 0))
              </td>

              <td>
                  {{ ($report->get('منفذ')['افطار الصائم'][0]->budget_out_of_org ?? 0) + ($report->get('مطلوب')['افطار الصائم'][0]->budget_out_of_org ?? 0)}}
                  @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['افطار الصائم'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['افطار الصائم'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
                {{ (@$report->get('منفذ')['افطار الصائم'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['افطار الصائم'][0]->budget_from_org ?? 0) +  ($report->get('منفذ')['افطار الصائم'][0]->budget_out_of_org ?? 0) + ($report->get('مطلوب')['افطار الصائم'][0]->budget_out_of_org ?? 0) }}
                @php($totalMoney 
                += (@$report->get('منفذ')['افطار الصائم'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['افطار الصائم'][0]->budget_out_of_org ?? 0)+  (@$report->get('منفذ')['افطار الصائم'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['افطار الصائم'][0]->budget_from_org ?? 0)
                )
              </td>

            </tr>

            <tr>
              <td>اكرامية عيد الفطر</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['اكرامية عيد الفطر']))
                    {{ $report->get('مطلوب')['اكرامية عيد الفطر'][0]->count }}
                    @php($totalNeed +=  $report->get('مطلوب')['اكرامية عيد الفطر'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['اكرامية عيد الفطر']))
                    {{ $report->get('منفذ')['اكرامية عيد الفطر'][0]->count }}
                    @php($totalDone += $report->get('منفذ')['اكرامية عيد الفطر'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['اكرامية عيد الفطر']) && isset($report->get('مطلوب')['اكرامية عيد الفطر']))
                    @if($report->get('منفذ')['اكرامية عيد الفطر'][0]->count !== 0 &&  $report->get('مطلوب')['اكرامية عيد الفطر'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['اكرامية عيد الفطر'][0]->count / $report->get('مطلوب')['اكرامية عيد الفطر'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

              <td>
                {{  (@$report->get('منفذ')['اكرامية عيد الفطر'][0]->budget ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الفطر'][0]->budget ?? 0) }}
                @php($totalBudget += (@$report->get('منفذ')['اكرامية عيد الفطر'][0]->budget ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الفطر'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['اكرامية عيد الفطر'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الفطر'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg += (@$report->get('منفذ')['اكرامية عيد الفطر'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الفطر'][0]->budget_from_org ?? 0))
              </td>
              
              <td>
                {{(@$report->get('منفذ')['اكرامية عيد الفطر'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الفطر'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['اكرامية عيد الفطر'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الفطر'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['اكرامية عيد الفطر'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الفطر'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['اكرامية عيد الفطر'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الفطر'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney += (@$report->get('منفذ')['اكرامية عيد الفطر'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الفطر'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['اكرامية عيد الفطر'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الفطر'][0]->budget_from_org ?? 0))
              </td>
            </tr>

            <tr>
              <td>اكرامية عيد الاضحي</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['اكرامية عيد الاضحي']))
                    {{ $report->get('مطلوب')['اكرامية عيد الاضحي'][0]->count }}
                    @php($totalNeed +=  $report->get('مطلوب')['اكرامية عيد الاضحي'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['اكرامية عيد الاضحي']))
                    {{ $report->get('منفذ')['اكرامية عيد الاضحي'][0]->count }}
                    @php($totalDone += $report->get('منفذ')['اكرامية عيد الاضحي'][0]->count )
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['اكرامية عيد الاضحي']) && isset($report->get('مطلوب')['اكرامية عيد الاضحي']))
                    @if($report->get('منفذ')['اكرامية عيد الاضحي'][0]->count !== 0 &&  $report->get('مطلوب')['اكرامية عيد الاضحي'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['اكرامية عيد الاضحي'][0]->count / $report->get('مطلوب')['اكرامية عيد الاضحي'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

              <td>
                {{  (@$report->get('منفذ')['اكرامية عيد الاضحي'][0]->budget ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الاضحي'][0]->budget ?? 0) }}
                @php($totalBudget += (@$report->get('منفذ')['اكرامية عيد الاضحي'][0]->budget ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الاضحي'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['اكرامية عيد الاضحي'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الاضحي'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg += (@$report->get('منفذ')['اكرامية عيد الاضحي'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الاضحي'][0]->budget_from_org ?? 0))
              </td>
              
              <td>
                {{(@$report->get('منفذ')['اكرامية عيد الاضحي'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الاضحي'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['اكرامية عيد الاضحي'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الاضحي'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['اكرامية عيد الاضحي'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الاضحي'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['اكرامية عيد الاضحي'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الاضحي'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney += (@$report->get('منفذ')['اكرامية عيد الاضحي'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الاضحي'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['اكرامية عيد الاضحي'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['اكرامية عيد الاضحي'][0]->budget_from_org ?? 0) )
              </td>
              

            </tr>

            <tr>
              <td>إعانات طارئة</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['إعانات طارئة']))
                    {{ $report->get('مطلوب')['إعانات طارئة'][0]->count }}
                    @php($totalNeed += $report->get('مطلوب')['إعانات طارئة'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['إعانات طارئة']))
                    {{ $report->get('منفذ')['إعانات طارئة'][0]->count }}
                    @php($totalDone += $report->get('منفذ')['إعانات طارئة'][0]->count )
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['إعانات طارئة']) && isset($report->get('مطلوب')['إعانات طارئة']))
                    @if($report->get('منفذ')['إعانات طارئة'][0]->count !== 0 &&  $report->get('مطلوب')['إعانات طارئة'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['إعانات طارئة'][0]->count / $report->get('مطلوب')['إعانات طارئة'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

              <td>
                {{  (@$report->get('منفذ')['إعانات طارئة'][0]->budget ?? 0) + (@$report->get('مطلوب')['إعانات طارئة'][0]->budget ?? 0) }}
                @php($totalBudget += (@$report->get('منفذ')['إعانات طارئة'][0]->budget ?? 0) + (@$report->get('مطلوب')['إعانات طارئة'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['إعانات طارئة'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['إعانات طارئة'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg += (@$report->get('منفذ')['إعانات طارئة'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['إعانات طارئة'][0]->budget_from_org ?? 0))
              </td>
              
              <td>
                {{(@$report->get('منفذ')['إعانات طارئة'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['إعانات طارئة'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['إعانات طارئة'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['إعانات طارئة'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['إعانات طارئة'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['إعانات طارئة'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['إعانات طارئة'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['إعانات طارئة'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney += (@$report->get('منفذ')['إعانات طارئة'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['إعانات طارئة'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['إعانات طارئة'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['إعانات طارئة'][0]->budget_from_org ?? 0) )
              </td>

            </tr>

            <tr>
              <td>مساعدات</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['مساعدات']))
                    {{ $report->get('مطلوب')['مساعدات'][0]->count }}
                    @php($totalNeed += $report->get('مطلوب')['مساعدات'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['مساعدات']))
                    {{ $report->get('منفذ')['مساعدات'][0]->count }}
                    @php($totalDone += $report->get('منفذ')['مساعدات'][0]->count )
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['مساعدات']) && isset($report->get('مطلوب')['مساعدات']))
                    @if($report->get('منفذ')['مساعدات'][0]->count !== 0 &&  $report->get('مطلوب')['مساعدات'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['مساعدات'][0]->count / $report->get('مطلوب')['مساعدات'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>
              
              <td>
                {{  (@$report->get('منفذ')['مساعدات'][0]->budget ?? 0) + (@$report->get('مطلوب')['مساعدات'][0]->budget ?? 0) }}
                @php($totalBudget += (@$report->get('منفذ')['مساعدات'][0]->budget ?? 0) + (@$report->get('مطلوب')['مساعدات'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['مساعدات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['مساعدات'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg += (@$report->get('منفذ')['مساعدات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['مساعدات'][0]->budget_from_org ?? 0))
              </td>
              
              <td>
                {{(@$report->get('منفذ')['مساعدات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['مساعدات'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['مساعدات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['مساعدات'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['مساعدات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['مساعدات'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['مساعدات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['مساعدات'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney += (@$report->get('منفذ')['مساعدات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['مساعدات'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['مساعدات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['مساعدات'][0]->budget_from_org ?? 0) )
              </td>
              
            </tr>

            <tr>
              <td>سفر و انتقال</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['سفر و انتقال']))
                    {{ $report->get('مطلوب')['سفر و انتقال'][0]->count }}
                    @php($totalNeed += $report->get('مطلوب')['سفر و انتقال'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['سفر و انتقال']))
                    {{ $report->get('منفذ')['سفر و انتقال'][0]->count }}
                    @php($totalDone +=  $report->get('منفذ')['سفر و انتقال'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['سفر و انتقال']) && isset($report->get('مطلوب')['سفر و انتقال']))
                    @if($report->get('منفذ')['سفر و انتقال'][0]->count !== 0 &&  $report->get('مطلوب')['سفر و انتقال'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['سفر و انتقال'][0]->count / $report->get('مطلوب')['سفر و انتقال'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>
     
              <td>
                {{  (@$report->get('منفذ')['سفر و انتقال'][0]->budget ?? 0) + (@$report->get('مطلوب')['سفر و انتقال'][0]->budget ?? 0) }}
                @php($totalBudget += (@$report->get('منفذ')['سفر و انتقال'][0]->budget ?? 0) + (@$report->get('مطلوب')['سفر و انتقال'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['سفر و انتقال'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['سفر و انتقال'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg += (@$report->get('منفذ')['سفر و انتقال'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['سفر و انتقال'][0]->budget_from_org ?? 0) )
              </td>
              
              <td>
                {{(@$report->get('منفذ')['سفر و انتقال'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['سفر و انتقال'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['سفر و انتقال'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['سفر و انتقال'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['سفر و انتقال'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['سفر و انتقال'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['سفر و انتقال'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['سفر و انتقال'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney +=  (@$report->get('منفذ')['سفر و انتقال'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['سفر و انتقال'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['سفر و انتقال'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['سفر و انتقال'][0]->budget_from_org ?? 0))
              </td>

            </tr>

            <tr>
              <td>احتفالات</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['احتفالات']))
                    {{ $report->get('مطلوب')['احتفالات'][0]->count }}
                    @php($totalNeed += $report->get('مطلوب')['احتفالات'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['احتفالات']))
                    {{ $report->get('منفذ')['احتفالات'][0]->count }}
                    @php($totalDone += $report->get('منفذ')['احتفالات'][0]->count )
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['احتفالات']) && isset($report->get('مطلوب')['احتفالات']))
                    @if($report->get('منفذ')['احتفالات'][0]->count !== 0 &&  $report->get('مطلوب')['احتفالات'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['احتفالات'][0]->count / $report->get('مطلوب')['احتفالات'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

                   
              <td>
                {{  (@$report->get('منفذ')['احتفالات'][0]->budget ?? 0) + (@$report->get('مطلوب')['احتفالات'][0]->budget ?? 0) }}
                @php($totalBudget +=  (@$report->get('منفذ')['احتفالات'][0]->budget ?? 0) + (@$report->get('مطلوب')['احتفالات'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['احتفالات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['احتفالات'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg +=  (@$report->get('منفذ')['احتفالات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['احتفالات'][0]->budget_from_org ?? 0) )
              </td>
              
              <td>
                {{(@$report->get('منفذ')['احتفالات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['احتفالات'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['احتفالات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['احتفالات'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['احتفالات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['احتفالات'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['احتفالات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['احتفالات'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney += (@$report->get('منفذ')['احتفالات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['احتفالات'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['احتفالات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['احتفالات'][0]->budget_from_org ?? 0) )
              </td>


            </tr>

            <tr>
              <td>راعي و رعية</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['راعي و رعية']))
                    {{ $report->get('مطلوب')['راعي و رعية'][0]->count }}
                    @php($totalNeed +=  $report->get('مطلوب')['راعي و رعية'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['راعي و رعية']))
                    {{ $report->get('منفذ')['راعي و رعية'][0]->count }}
                    @php($totalDone += $report->get('منفذ')['راعي و رعية'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['راعي و رعية']) && isset($report->get('مطلوب')['راعي و رعية']))
                    @if($report->get('منفذ')['راعي و رعية'][0]->count !== 0 &&  $report->get('مطلوب')['راعي و رعية'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['راعي و رعية'][0]->count / $report->get('مطلوب')['راعي و رعية'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

              <td>
                {{  (@$report->get('منفذ')['راعي و رعية'][0]->budget ?? 0) + (@$report->get('مطلوب')['راعي و رعية'][0]->budget ?? 0) }}
                @php($totalBudget += (@$report->get('منفذ')['راعي و رعية'][0]->budget ?? 0) + (@$report->get('مطلوب')['راعي و رعية'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['راعي و رعية'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['راعي و رعية'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg += (@$report->get('منفذ')['راعي و رعية'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['راعي و رعية'][0]->budget_from_org ?? 0))
              </td>
              
              <td>
                {{(@$report->get('منفذ')['راعي و رعية'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['راعي و رعية'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['راعي و رعية'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['راعي و رعية'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['راعي و رعية'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['راعي و رعية'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['راعي و رعية'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['راعي و رعية'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney +=  (@$report->get('منفذ')['راعي و رعية'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['راعي و رعية'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['راعي و رعية'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['راعي و رعية'][0]->budget_from_org ?? 0) )
              </td>

            </tr>

            <tr>
              <td>زيارات المشرفين</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['زيارات المشرفين']))
                    {{ $report->get('مطلوب')['زيارات المشرفين'][0]->count }}
                    @php($totalNeed += $report->get('مطلوب')['زيارات المشرفين'][0]->count )
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['زيارات المشرفين']))
                    {{ $report->get('منفذ')['زيارات المشرفين'][0]->count }}
                    @php($totalDone +=  $report->get('منفذ')['زيارات المشرفين'][0]->count )
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['زيارات المشرفين']) && isset($report->get('مطلوب')['زيارات المشرفين']))
                    @if($report->get('منفذ')['زيارات المشرفين'][0]->count !== 0 &&  $report->get('مطلوب')['زيارات المشرفين'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['زيارات المشرفين'][0]->count / $report->get('مطلوب')['زيارات المشرفين'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

              <td>
                {{  (@$report->get('منفذ')['زيارات المشرفين'][0]->budget ?? 0) + (@$report->get('مطلوب')['زيارات المشرفين'][0]->budget ?? 0) }}
                @php($totalBudget += (@$report->get('منفذ')['زيارات المشرفين'][0]->budget ?? 0) + (@$report->get('مطلوب')['زيارات المشرفين'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['زيارات المشرفين'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['زيارات المشرفين'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg += (@$report->get('منفذ')['زيارات المشرفين'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['زيارات المشرفين'][0]->budget_from_org ?? 0))
              </td>
              
              <td>
                {{(@$report->get('منفذ')['زيارات المشرفين'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['زيارات المشرفين'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['زيارات المشرفين'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['زيارات المشرفين'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['زيارات المشرفين'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['زيارات المشرفين'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['زيارات المشرفين'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['زيارات المشرفين'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney +=  (@$report->get('منفذ')['زيارات المشرفين'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['زيارات المشرفين'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['زيارات المشرفين'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['زيارات المشرفين'][0]->budget_from_org ?? 0) )
              </td>


            </tr>

            <tr>
              <td>قوت عام</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['قوت عام']))
                    {{ $report->get('مطلوب')['قوت عام'][0]->count }}
                    @php($totalNeed +=  $report->get('مطلوب')['قوت عام'][0]->count )
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['قوت عام']))
                    {{ $report->get('منفذ')['قوت عام'][0]->count }}
                    @php($totalDone += $report->get('منفذ')['قوت عام'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['قوت عام']) && isset($report->get('مطلوب')['قوت عام']))
                    @if($report->get('منفذ')['قوت عام'][0]->count !== 0 &&  $report->get('مطلوب')['قوت عام'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['قوت عام'][0]->count / $report->get('مطلوب')['قوت عام'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

              
              <td>
                {{  (@$report->get('منفذ')['قوت عام'][0]->budget ?? 0) + (@$report->get('مطلوب')['قوت عام'][0]->budget ?? 0) }}
                @php($totalBudget += (@$report->get('منفذ')['قوت عام'][0]->budget ?? 0) + (@$report->get('مطلوب')['قوت عام'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['قوت عام'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['قوت عام'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg += (@$report->get('منفذ')['قوت عام'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['قوت عام'][0]->budget_from_org ?? 0))
              </td>
              
              <td>
                {{(@$report->get('منفذ')['قوت عام'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['قوت عام'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['قوت عام'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['قوت عام'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['قوت عام'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['قوت عام'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['قوت عام'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['قوت عام'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney += (@$report->get('منفذ')['قوت عام'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['قوت عام'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['قوت عام'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['قوت عام'][0]->budget_from_org ?? 0) )
              </td>


            </tr>

            <tr>
              <td>صيانة سكن</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['صيانة سكن']))
                    {{ $report->get('مطلوب')['صيانة سكن'][0]->count }}
                    @php($totalNeed += $report->get('مطلوب')['صيانة سكن'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['صيانة سكن']))
                    {{ $report->get('منفذ')['صيانة سكن'][0]->count }}
                    @php($totalDone += $report->get('منفذ')['صيانة سكن'][0]->count )
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['صيانة سكن']) && isset($report->get('مطلوب')['صيانة سكن']))
                    @if($report->get('منفذ')['صيانة سكن'][0]->count !== 0 &&  $report->get('مطلوب')['صيانة سكن'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['صيانة سكن'][0]->count / $report->get('مطلوب')['صيانة سكن'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

                            
              <td>
                {{  (@$report->get('منفذ')['صيانة سكن'][0]->budget ?? 0) + (@$report->get('مطلوب')['صيانة سكن'][0]->budget ?? 0) }}
                @php($totalBudget +=  (@$report->get('منفذ')['صيانة سكن'][0]->budget ?? 0) + (@$report->get('مطلوب')['صيانة سكن'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['صيانة سكن'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['صيانة سكن'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg += (@$report->get('منفذ')['صيانة سكن'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['صيانة سكن'][0]->budget_from_org ?? 0))
              </td>
              
              <td>
                {{(@$report->get('منفذ')['صيانة سكن'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['صيانة سكن'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['صيانة سكن'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['صيانة سكن'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['صيانة سكن'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['صيانة سكن'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['صيانة سكن'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['صيانة سكن'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney += (@$report->get('منفذ')['صيانة سكن'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['صيانة سكن'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['صيانة سكن'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['صيانة سكن'][0]->budget_from_org ?? 0) )
              </td>


            </tr>

            <tr>
              <td>إيجار</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['إيجار']))
                    {{ $report->get('مطلوب')['إيجار'][0]->count }}
                    @php($totalNeed += $report->get('مطلوب')['إيجار'][0]->count )
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['إيجار']))
                    {{ $report->get('منفذ')['إيجار'][0]->count }}
                    @php($totalDone += $report->get('منفذ')['إيجار'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['إيجار']) && isset($report->get('مطلوب')['إيجار']))
                    @if($report->get('منفذ')['إيجار'][0]->count !== 0 &&  $report->get('مطلوب')['إيجار'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['إيجار'][0]->count / $report->get('مطلوب')['إيجار'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

              <td>
                {{  (@$report->get('منفذ')['إيجار'][0]->budget ?? 0) + (@$report->get('مطلوب')['إيجار'][0]->budget ?? 0) }}
                @php($totalBudget += (@$report->get('منفذ')['إيجار'][0]->budget ?? 0) + (@$report->get('مطلوب')['إيجار'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['إيجار'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['إيجار'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg += (@$report->get('منفذ')['إيجار'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['إيجار'][0]->budget_from_org ?? 0))
              </td>
              
              <td>
                {{(@$report->get('منفذ')['إيجار'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['إيجار'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['إيجار'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['إيجار'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['إيجار'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['إيجار'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['إيجار'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['إيجار'][0]->budget_from_org ?? 0) 
              }}

              @php($totalMoney += (@$report->get('منفذ')['إيجار'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['إيجار'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['إيجار'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['إيجار'][0]->budget_from_org ?? 0) )
              </td>


            </tr>

            <tr>
              <td>رسوم سكن</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['رسوم سكن']))
                    {{ $report->get('مطلوب')['رسوم سكن'][0]->count }}
                    @php($totalNeed += $report->get('مطلوب')['رسوم سكن'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['رسوم سكن']))
                    {{ $report->get('منفذ')['رسوم سكن'][0]->count }}
                    @php($totalDone += $report->get('منفذ')['رسوم سكن'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['رسوم سكن']) && isset($report->get('مطلوب')['رسوم سكن']))
                    @if($report->get('منفذ')['رسوم سكن'][0]->count !== 0 &&  $report->get('مطلوب')['رسوم سكن'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['رسوم سكن'][0]->count / $report->get('مطلوب')['رسوم سكن'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

              <td>
                {{  (@$report->get('منفذ')['رسوم سكن'][0]->budget ?? 0) + (@$report->get('مطلوب')['رسوم سكن'][0]->budget ?? 0) }}
                @php($totalBudget += (@$report->get('منفذ')['رسوم سكن'][0]->budget ?? 0) + (@$report->get('مطلوب')['رسوم سكن'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['رسوم سكن'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['رسوم سكن'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg += (@$report->get('منفذ')['رسوم سكن'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['رسوم سكن'][0]->budget_from_org ?? 0))
              </td>
              
              <td>
                {{(@$report->get('منفذ')['رسوم سكن'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['رسوم سكن'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['رسوم سكن'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['رسوم سكن'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['رسوم سكن'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['رسوم سكن'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['رسوم سكن'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['رسوم سكن'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney +=  (@$report->get('منفذ')['رسوم سكن'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['رسوم سكن'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['رسوم سكن'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['رسوم سكن'][0]->budget_from_org ?? 0) )
              </td>

            </tr>

            <tr>
              <td>رسوم مشروعات</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['رسوم مشروعات']))
                    {{ $report->get('مطلوب')['رسوم مشروعات'][0]->count }}
                    @php($totalNeed +=  $report->get('مطلوب')['رسوم مشروعات'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['رسوم مشروعات']))
                    {{ $report->get('منفذ')['رسوم مشروعات'][0]->count }}
                    @php($totalDone += $report->get('منفذ')['رسوم مشروعات'][0]->count )
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['رسوم مشروعات']) && isset($report->get('مطلوب')['رسوم مشروعات']))
                    @if($report->get('منفذ')['رسوم مشروعات'][0]->count !== 0 &&  $report->get('مطلوب')['رسوم مشروعات'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['رسوم مشروعات'][0]->count / $report->get('مطلوب')['رسوم مشروعات'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

              
              
              <td>
                {{  (@$report->get('منفذ')['رسوم مشروعات'][0]->budget ?? 0) + (@$report->get('مطلوب')['رسوم مشروعات'][0]->budget ?? 0) }}
                @php($totalBudget += (@$report->get('منفذ')['رسوم مشروعات'][0]->budget ?? 0) + (@$report->get('مطلوب')['رسوم مشروعات'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['رسوم مشروعات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['رسوم مشروعات'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg +=  (@$report->get('منفذ')['رسوم مشروعات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['رسوم مشروعات'][0]->budget_from_org ?? 0))
              </td>
              
              <td>
                {{(@$report->get('منفذ')['رسوم مشروعات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['رسوم مشروعات'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['رسوم مشروعات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['رسوم مشروعات'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['رسوم مشروعات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['رسوم مشروعات'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['رسوم مشروعات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['رسوم مشروعات'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney += 
                 (@$report->get('منفذ')['رسوم مشروعات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['رسوم مشروعات'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['رسوم مشروعات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['رسوم مشروعات'][0]->budget_from_org ?? 0) 
              )
              </td>

            </tr>

            <tr>
              <td>تأهيل مشروعات</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['تأهيل مشروعات']))
                    {{ $report->get('مطلوب')['تأهيل مشروعات'][0]->count }}
                  @php($totalNeed +=  $report->get('مطلوب')['تأهيل مشروعات'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['تأهيل مشروعات']))
                    {{ $report->get('منفذ')['تأهيل مشروعات'][0]->count }}
                    @php($totalDone +=  $report->get('منفذ')['تأهيل مشروعات'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['تأهيل مشروعات']) && isset($report->get('مطلوب')['تأهيل مشروعات']))
                    @if($report->get('منفذ')['تأهيل مشروعات'][0]->count !== 0 &&  $report->get('مطلوب')['تأهيل مشروعات'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['تأهيل مشروعات'][0]->count / $report->get('مطلوب')['تأهيل مشروعات'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>
              <td>
                {{  (@$report->get('منفذ')['تأهيل مشروعات'][0]->budget ?? 0) + (@$report->get('مطلوب')['تأهيل مشروعات'][0]->budget ?? 0) }}
                @php($totalBudget += (@$report->get('منفذ')['تأهيل مشروعات'][0]->budget ?? 0) + (@$report->get('مطلوب')['تأهيل مشروعات'][0]->budget ?? 0))
              </td>

              <td>
                {{  (@$report->get('منفذ')['تأهيل مشروعات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['تأهيل مشروعات'][0]->budget_from_org ?? 0) }}
                @php($totalBudgetFromOrg += (@$report->get('منفذ')['تأهيل مشروعات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['تأهيل مشروعات'][0]->budget_from_org ?? 0) )
              </td>
              
              <td>
                {{(@$report->get('منفذ')['تأهيل مشروعات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['تأهيل مشروعات'][0]->budget_out_of_org ?? 0)}}
                @php($totalBudgetOutOfOrg += (@$report->get('منفذ')['تأهيل مشروعات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['تأهيل مشروعات'][0]->budget_out_of_org ?? 0))
              </td>

              <td>
              {{ 
                (@$report->get('منفذ')['تأهيل مشروعات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['تأهيل مشروعات'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['تأهيل مشروعات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['تأهيل مشروعات'][0]->budget_from_org ?? 0) 
              }}
              @php($totalMoney +=  (@$report->get('منفذ')['تأهيل مشروعات'][0]->budget_out_of_org ?? 0) + (@$report->get('مطلوب')['تأهيل مشروعات'][0]->budget_out_of_org ?? 0) + (@$report->get('منفذ')['تأهيل مشروعات'][0]->budget_from_org ?? 0) + (@$report->get('مطلوب')['تأهيل مشروعات'][0]->budget_from_org ?? 0))
              </td>

            </tr>

            <tr>
              <td>دعم استراتيجي</td>
              <td>
                @if(!is_null($report->get('مطلوب')))
                  @if(isset($report->get('مطلوب')['دعم استراتيجي']))
                    {{ $report->get('مطلوب')['دعم استراتيجي'][0]->count }}
                    @php($totalNeed += $report->get('مطلوب')['دعم استراتيجي'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>
              <td>
                @if(!is_null($report->get('منفذ')))
                  @if(isset($report->get('منفذ')['دعم استراتيجي']))
                    {{ $report->get('منفذ')['دعم استراتيجي'][0]->count }} 
                    @php($totalDone += $report->get('منفذ')['دعم استراتيجي'][0]->count)
                  @else
                    0
                  @endif
                @else
                    0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                  @if(isset($report->get('منفذ')['دعم استراتيجي']) && isset($report->get('مطلوب')['دعم استراتيجي']))
                    @if($report->get('منفذ')['دعم استراتيجي'][0]->count !== 0 &&  $report->get('مطلوب')['دعم استراتيجي'][0]->count !== 0)
                      {{ round(( $report->get('منفذ')['دعم استراتيجي'][0]->count / $report->get('مطلوب')['دعم استراتيجي'][0]->count ) * 100, 1) . '%' }}
                    @else
                      0%
                    @endif
                  @else
                    0%
                  @endif
                  @else
                    0%
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))                  
                  @if(isset($report->get('منفذ')['دعم استراتيجي']) && isset($report->get('مطلوب')['دعم استراتيجي']))
                    {{ $report->get('منفذ')['دعم استراتيجي'][0]->budget + $report->get('مطلوب')['دعم استراتيجي'][0]->budget }}
                    @php($totalBudget += $report->get('منفذ')['دعم استراتيجي'][0]->budget + $report->get('مطلوب')['دعم استراتيجي'][0]->budget)
                  @else
                    0
                  @endif
                @else
                  0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                @if(isset($report->get('منفذ')['دعم استراتيجي']) && isset($report->get('مطلوب')['دعم استراتيجي']))
                  {{ $report->get('منفذ')['دعم استراتيجي'][0]->budget_from_org + $report->get('مطلوب')['دعم استراتيجي'][0]->budget_from_org }}
                  @php($totalBudgetFromOrg += $report->get('منفذ')['دعم استراتيجي'][0]->budget_from_org + $report->get('مطلوب')['دعم استراتيجي'][0]->budget_from_org )
                @else
                  0
                @endif
                @else
                  0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                @if(isset($report->get('منفذ')['دعم استراتيجي']) && isset($report->get('مطلوب')['دعم استراتيجي']))
                  {{ $report->get('منفذ')['دعم استراتيجي'][0]->budget_out_of_org + $report->get('مطلوب')['دعم استراتيجي'][0]->budget_out_of_org }}
                  @php($totalBudgetOutOfOrg += $report->get('منفذ')['دعم استراتيجي'][0]->budget_out_of_org + $report->get('مطلوب')['دعم استراتيجي'][0]->budget_out_of_org)
                @else
                  0
                @endif
                @else
                  0
                @endif
              </td>

              <td>
                @if(!is_null($report->get('منفذ')) && !is_null($report->get('مطلوب')))
                @if(isset($report->get('منفذ')['دعم استراتيجي']) && isset($report->get('مطلوب')['دعم استراتيجي']))
                  {{ $report->get('منفذ')['دعم استراتيجي'][0]->budget_from_org + $report->get('مطلوب')['دعم استراتيجي'][0]->budget_from_org + $report->get('منفذ')['دعم استراتيجي'][0]->budget_out_of_org  + $report->get('مطلوب')['دعم استراتيجي'][0]->budget_out_of_org }}
                  @php($totalMoney += $report->get('منفذ')['دعم استراتيجي'][0]->budget_from_org + $report->get('مطلوب')['دعم استراتيجي'][0]->budget_from_org + $report->get('منفذ')['دعم استراتيجي'][0]->budget_out_of_org  + $report->get('مطلوب')['دعم استراتيجي'][0]->budget_out_of_org)
                @else
                  0
                @endif
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