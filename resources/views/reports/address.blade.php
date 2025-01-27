@include('components.header', ['page_title' => 'تقارير السكن'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تقارير السكن</h4>
        </div>
		  <x-table>
			  <x-slot:head>
			  <th>نوع الملكية</th>
              <th>ملك</th>
              <th>مؤجر</th>
              <th>حكومي</th>
              <th>ورثة</th>
              <th>إستضافة</th>
              <th>قروي</th>
              <th>رحل </th>
              <th>اخرى</th>
              <th>المجموع</th>
            </x-slot:head>
			
			<x-slot:body>
				<tr>
					@php($totalCount = 0)
					<td>العدد</td>
      				@foreach($report as $row)
      					<td title="{{ $row->type }}">
      						{{ $row->count }}
      						@php($totalCount += $row->count)
      					</td>
      				@endforeach
      				<td title="المجموع">{{ $totalCount }}</td>
				</tr>

				<tr>
					<td>النسبة</td>
              @php($totalPrecentages = 0)
      				@foreach($report as $row)
      					<td title="{{ $row->type }}">{{ round(($row->count / 8) * 100 , 2) . '%' }}</td>
      				@endforeach
          <td>{{  100 . '%'  }}</td>
				</tr>

			</x-slot:body>

		  </x-table>

      <hr>

      <div>
        <h5>تقارير خدمات السكن</h5>
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
              <td>تشييد</td>

                <td>{{ $homeServicesReport->get('build')['need']->count ?? 0 }}</td>
                <td>{{ $homeServicesReport->get('build')['done']->count ?? 0 }}</td>
                <td>{{ $homeServicesReport->get('precentages')['build'] . '%'}}</td>

                <td>{{ number_format(($homeServicesReport->get('build')['need']->totalBudget ?? 0) +  ($homeServicesReport->get('build')['done']->totalBudget ?? 0)) }}</td>

                <td>{{ number_format(($homeServicesReport->get('build')['need']->budget_from_org ?? 0 ) +  ($homeServicesReport->get('build')['done']->budget_from_org ?? 0)) }}</td>

                <td>{{ number_format(($homeServicesReport->get('build')['need']->budget_out_of_org ?? 0) +  ($homeServicesReport->get('build')['done']->budget_out_of_org ?? 0)) }}</td>

                <td>
                  {{  
                    number_format(
                          (($homeServicesReport->get('build')['need']->budget_from_org ?? 0)  +  ($homeServicesReport->get('build')['done']->budget_from_org ?? 0))
                        + (($homeServicesReport->get('build')['need']->budget_out_of_org ?? 0) +  ($homeServicesReport->get('build')['done']->budget_out_of_org ?? 0))
                      )
                   }}
                </td>


            </tr>
            <tr>
              <td>اكمال تشييد</td>
                
              <td>{{ $homeServicesReport->get('complete_build')['need']->count ?? 0 }}</td>
                <td>{{ $homeServicesReport->get('complete_build')['done']->count ?? 0 }}</td>
                <td>{{ $homeServicesReport->get('precentages')['complete_build']. '%'}}</td>

                <td>{{ number_format(($homeServicesReport->get('complete_build')['need']->totalBudget ?? 0) +  ($homeServicesReport->get('complete_build')['done']->totalBudget ?? 0)) }}</td>

                <td>{{ number_format(($homeServicesReport->get('complete_build')['need']->budget_from_org ?? 0 ) +  ($homeServicesReport->get('complete_build')['done']->budget_from_org ?? 0)) }}</td>

                <td>{{ number_format(($homeServicesReport->get('complete_build')['need']->budget_out_of_org ?? 0) +  ($homeServicesReport->get('complete_build')['done']->budget_out_of_org ?? 0)) }}</td>

                <td>
                  {{  
                    number_format(
                          (($homeServicesReport->get('complete_build')['need']->budget_from_org ?? 0)  +  ($homeServicesReport->get('complete_build')['done']->budget_from_org ?? 0))
                        + (($homeServicesReport->get('complete_build')['need']->budget_out_of_org ?? 0) +  ($homeServicesReport->get('complete_build')['done']->budget_out_of_org ?? 0))
                      )
                   }}
                </td>
            </tr>

            <tr>
              <td>الاجمالي</td>
              <td>{{ ($homeServicesReport->get('build')['need']->count ?? 0) + ($homeServicesReport->get('complete_build')['need']->count ?? 0)  }}</td>
              <td>{{ ($homeServicesReport->get('build')['done']->count ?? 0) + ($homeServicesReport->get('complete_build')['done']->count ?? 0)  }}</td>
              <td>{{ 
                 round( (
                    ( ($homeServicesReport->get('build')['done']->count ?? 0) + ($homeServicesReport->get('complete_build')['done']->count ?? 0) )
                    / 
                    ( ($homeServicesReport->get('build')['need']->count ?? 0) + ($homeServicesReport->get('complete_build')['need']->count ?? 0) )
                  ) * 100, 1)
                 . '%'}}
              </td>
              <td>
                {{ 
                  number_format(
                    ($homeServicesReport->get('build')['need']->totalBudget ?? 0) +  ($homeServicesReport->get('build')['done']->totalBudget ?? 0) 
                  + ($homeServicesReport->get('complete_build')['need']->totalBudget ?? 0) +  ($homeServicesReport->get('complete_build')['done']->totalBudget ?? 0)) 
                }}
              </td>
              <td>
                {{ 
                  number_format(
                    ($homeServicesReport->get('build')['need']->budget_from_org ?? 0) +  ($homeServicesReport->get('build')['done']->budget_from_org ?? 0) 
                  + ($homeServicesReport->get('complete_build')['need']->budget_from_org ?? 0) +  ($homeServicesReport->get('complete_build')['done']->budget_from_org ?? 0)) 
                }}
              </td>
              <td>
                {{ 
                  number_format(
                    ($homeServicesReport->get('build')['need']->budget_out_of_org ?? 0) +  ($homeServicesReport->get('build')['done']->budget_out_of_org ?? 0) 
                  + ($homeServicesReport->get('complete_build')['need']->budget_out_of_org ?? 0) +  ($homeServicesReport->get('complete_build')['done']->budget_out_of_org ?? 0)) 
                }}
              </td>
              <td>
                {{  
                  number_format(
                    (($homeServicesReport->get('build')['need']->budget_from_org ?? 0)  +  ($homeServicesReport->get('build')['done']->budget_from_org ?? 0))
                  + (($homeServicesReport->get('build')['need']->budget_out_of_org ?? 0) +  ($homeServicesReport->get('build')['done']->budget_out_of_org ?? 0))
                  + (($homeServicesReport->get('complete_build')['need']->budget_from_org ?? 0) +  ($homeServicesReport->get('complete_build')['done']->budget_from_org ?? 0))
                  + (($homeServicesReport->get('complete_build')['need']->budget_out_of_org ?? 0) +  ($homeServicesReport->get('complete_build')['done']->budget_out_of_org ?? 0))
                  )
                }}
              </td>
            </tr>

           </x-slot:body>

         </x-table>
      </div>

      </div>
    </div>

  @include('components.footer')