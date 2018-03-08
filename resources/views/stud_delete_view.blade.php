<html>
   
   <head>
      <title>View Student Records</title>
   </head>
   
   <body>
      <table border = "1">
         <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Edit</td>
         </tr>
         @foreach ($users as $user)
         <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td><a href = 'delete/{{ $user->id }}'>Delete</a></td>
         </tr>
         @endforeach
         @foreach ($users2 as $user2)
         <tr>
            <td>{{ $user2->id }}</td>
            <td>{{ $user2->name }}</td>
            <td><a href = 'delete/{{ $user->id }}'>Delete</a></td>
         </tr>
         @endforeach
      </table>
   
   </body>
</html>