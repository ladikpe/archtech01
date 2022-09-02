<table >
          <thead>
            <tr>
             
              <th>
                S/N
              </th>
              <th  >Name</th>
              <th>Staff ID</th>
              <th >Gender</th>
              <th >Email</th>
              <th >Date of First Appointment</th>
              <th >Date of Confirmation</th>
               <th >Date of present Appointment</th>
               <th >Date of Birth</th>
               <th >State of Origin</th>
               <th >LGA of Origin</th>
              <th>Cadre</th>
              <th>Rank</th>
              <th>Grade</th>
            </tr>
          </thead>
          <tbody>
          	@forelse($users as $key=> $user)
            <tr >
              <td >{{$key + 1}}</td>
              
              <td class="cell-300">

                {{$user->name}}
              </td>
              <td class="cell-300" >{{$user->emp_num}}</td>
               <td class="cell-300" >{{$user->sex=='M'?'Male':($user->sex=='F'?'Female':'')}}</td>
              
             
              <td class="cell-300" >{{$user->email}}</td>
               
              
              <td>@if($user->hiredate) {{date('m/d/Y',strtotime($user->hiredate))}}  @endif</td>
             
               
              <td>@if($user->confirmation_date) {{date('m/d/Y',strtotime($user->confirmation_date))}}  @endif</td>
             
              
              <td> @if($user->hiredate) {{date('m/d/Y',strtotime($user->hiredate))}}  @endif</td>
             
               
              <td>@if($user->dob) {{date('m/d/Y',strtotime($user->dob))}} @endif</td>
              
              <td> {{$user->state?$user->state->name:''}}</td>  
              <td> {{$user->lga?$user->lga->name:''}}</td>
              <td> {{$user->cadre?$user->cadre->name:''}}</td>  
              <td> {{$user->rank?$user->rank->name:''}}</td>  
               <td> {{$user->rank?($user->rank->grade?$user->rank->grade->level:''):''}}</td>  
              
              
            </tr>
            @empty
            @endforelse

          </tbody>
        </table>
