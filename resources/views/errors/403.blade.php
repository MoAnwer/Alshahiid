@include('components.header', ['page_title' => '403'])
 <div id="wrapper vh-100">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
     <div id="content w-100">	  

      @include('components.navbar')
      
      <div class="mt-4 w-100 mx-auto">
        <div class="mx-auto w-100" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
          <h1 class="text-secondary mb-4" style="font-size: 100px; margin-top: 100px">403</h1>
          <h4>لا تملك الصلاحيات لعرض هذا المحتوى</h4>
        </div>
      </div>

    </div>

</div>

@include('components.footer')