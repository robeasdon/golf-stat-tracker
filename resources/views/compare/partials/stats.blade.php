<div class="col-md-6">
    <table class="table">
        <tbody>
        <tr>
            <td>Rounds Played</td>
            <td @if ($user1->rounds_played > $user2->rounds_played) class="alert-success" @endif>
                {{ $user1->rounds_played }}
            </td>
        </tr>
        <tr>
            <td>Total Eagles</td>
            <td @if ($user1->total_eagles > $user2->total_eagles) class="alert-success" @endif>
                {{ $user1->total_eagles }}
            </td>
        </tr>
        <tr>
            <td>Total Birdies</td>
            <td @if ($user1->total_birdies > $user2->total_birdies) class="alert-success" @endif>
                {{ $user1->total_birdies }}
            </td>
        </tr>
        <tr>
            <td>Total Pars</td>
            <td @if ($user1->total_pars > $user2->total_pars) class="alert-success" @endif>
                {{ $user1->total_pars }}
            </td>
        </tr>
        <tr>
            <td>Total Bogies</td>
            <td @if ($user1->total_bogies < $user2->total_bogies) class="alert-success" @endif>
                {{ $user1->total_bogies }}
            </td>
        </tr>
        <tr>
            <td>Total Doubles</td>
            <td @if ($user1->total_double_bogies < $user2->total_double_bogies) class="alert-success" @endif>
                {{ $user1->total_double_bogies }}
            </td>
        </tr>
        <tr>
            <td>Average Score</td>
            <td @if ($user1->avg_strokes < $user2->avg_strokes) class="alert-success" @endif>
                {{ round($user1->avg_strokes, 2) }}
            </td>
        </tr>
        <tr>
            <td>Average Putts Per Hole</td>
            <td @if ($user1->avg_putts_per_hole < $user2->avg_putts_per_hole) class="alert-success" @endif>
                {{ round($user1->avg_putts_per_hole, 2) }}
            </td>
        </tr>
        <tr>
            <td>Average Score Par 3</td>
            <td @if ($user1->avg_strokes_par3 < $user2->avg_strokes_par3) class="alert-success" @endif>
                {{ round($user1->avg_strokes_par3, 2) }}
            </td>
        </tr>
        <tr>
            <td>Average Score Par 4</td>
            <td @if ($user1->avg_strokes_par4 < $user2->avg_strokes_par4) class="alert-success" @endif>
                {{ round($user1->avg_strokes_par4, 2) }}
            </td>
        </tr>
        <tr>
            <td>Average Score Par 5</td>
            <td @if ($user1->avg_strokes_par5 < $user2->avg_strokes_par5) class="alert-success" @endif>
                {{ round($user1->avg_strokes_par5, 2) }}
            </td>
        </tr>
        </tbody>
    </table>
</div>