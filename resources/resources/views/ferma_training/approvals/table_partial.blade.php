<table class="table table-striped" style="border: 1px solid #eee;">
    <tr>
        <th>
            Pointer
        </th>
        <th>
            Stage
        </th>
        <th>
            Status
        </th>
        <th>
            Approved By
        </th>
        <th>
            Requires Approval Of
        </th>
        <th>
            Actions
        </th>
    </tr>
    @foreach ($list as $k=>$item)
        <tr>
            <td>
                @if ($k == 0)
                    @if ($item->status == 1)
                        <i style="color: green;">Passed</i>
                    @else
                        Current
                    @endif

                @else
                    <i style="color: green;">Passed</i>
                @endif
            </td>
            <td>
                {{ $item->stage->name }}
            </td>
            <td>
                @if ($item->status == 0)
                    Pending Approval
                @endif

                @if ($item->status == 1)
                    Approved
                @endif

                @if ($item->status == 2)
                    Rejected
                @endif

            </td>
            <td>
                {{ $item->getApprovedBy() }}
            </td>
            <td>
                {{ $item->getRequiresApprovalIdentity() }}
            </td>
            <td>
               @if ($action)
                @if ($item->status != 1 && $item->canBeApprovedBy(Auth::user()))
                    <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#approve-reject{{ $item->id }}">Approve / Reject</a>
                @else
                    <b style="color: green;">Done</b>
                @endif
              @else
                    @if ($item->status != 1)
                        <b style="color: orange;">Pending</b>
                    @else
                        <b style="color: green;">Done</b>
                    @endif
              @endif
            </td>
        </tr>
    @endforeach
</table>