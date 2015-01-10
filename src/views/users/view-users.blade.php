@section('content')
<div class="row">
    <div class="col-md-12"><h1>View all users</h1></div>
</div>
@include('administer::masters.internal-nav')
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Logged In</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->updated_at}}</td>
                    <td class="col-md-2" align="right">
                        <span class="edit">Edit</span> /
                        <span class="confirm-delete">{{link_to('users/delete/'.$user->id, 'Delete')}}</span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php echo $users->links(); ?>
    </div>
</div>
@show