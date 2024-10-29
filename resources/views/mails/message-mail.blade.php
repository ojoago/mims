<div>
    <!-- He who is contented is rich. - Laozi -->
    <!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->

@include('mails.mail-header')

<table width="100%">
    <tr>
        <td class="inner-td" style="background-color: #222 !important;color:#FFF">
            {{-- <p>
                your number platform
            </p> --}}
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td class="inner-td">
            <!-- <p class="h2" style="text-align:left !important;">Hi {{--$param['name']--}},</p> -->
            <p class="text">
            {!!$param['message']!!}
        </p>
        </td>
    </tr>
</table>
</div>
</td>
</tr>
<!-- end heading, paragraph and button  -->
</table>
@include('mails.mail-footer')
</div>
