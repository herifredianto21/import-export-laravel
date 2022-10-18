<div>
    <table class="table table-dark" id="example">
        
        <tbody>
          @foreach ($users as $userss)
              <tr class="bg-gray-50 border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-4 px-6">
                    {{ $userss->id}}
                </td>
                <td class="py-4 px-6">
                    {{$userss->name}}
                </td>
                <td class="py-4 px-6">
                    {{$userss->email}}
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
</div>