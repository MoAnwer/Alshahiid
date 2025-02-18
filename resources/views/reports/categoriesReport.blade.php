@include('components.header', ['page_title' => 'تصنيف الاسر'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تصنيف الاسر</h4>
          <button class="mx-4 btn  btn-primary active" onclick="printTable()">
            <i class="bi bi-printer ml-2"></i>
                طباعة 
          </button>
        </div>
        <hr>

        <x-search-form />
        
        <x-table>
          <x-slot:head>
            <th>الشريحة</th>
            <th>أ</th>
            <th>ب</th>
            <th>ج</th>
            <th>د</th>
            <th>الاجمالي</th>
          </x-slot:head>
			
			    <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>
                @empty(!$report->get('أ'))
                  {{ $report->get('أ')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @empty(!$report->get('ب'))
                  {{ $report->get('ب')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @empty(!$report->get('ج'))
                {{ $report->get('ج')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @empty(!$report->get('د'))
                {{ $report->get('د')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @php
                  $total = 
                  (empty(!$report->get('أ')) ? $report->get('أ')[0]->count : 0 )+
                  (empty(!$report->get('ب')) ? $report->get('ب')[0]->count : 0) + 
                  (empty(!$report->get('ج')) ? $report->get('ج')[0]->count : 0) + 
                  (empty(!$report->get('د')) ? $report->get('د')[0]->count : 0)

                @endphp
                {{ 
                  $total
                }}
              </td>
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                @empty(!$report->get('أ'))
                  {{ round(($report->get('أ')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>
                @empty(!$report->get('ب'))
                  {{  round(($report->get('ب')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>
                @empty(!$report->get('ج'))
                {{  round(($report->get('ج')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>
                @empty(!$report->get('د'))
                {{  round(($report->get('د')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>{{ $total > 0 ? '100%' : $total.'%' }}</td>
            </tr>

            <caption class="text-primary">
              تقرير تصنيف الاسر
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

      </div>
    </div>

  @include('components.footer')