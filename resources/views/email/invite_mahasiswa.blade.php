<style>
    html,
    body {
        padding: 0;
        margin: 0;
        font-family: Inter, Helvetica, "sans-serif";
    }
    a:hover {
        color: #009ef7;
    }
</style>
<div id="#kt_app_body_content"
    style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:20px 0 20px 0; width:100%;">
    <div
        style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto"
            style="border-collapse:collapse">
            <tbody>
                <tr>
                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                        <div style="text-align:center; margin:0 15px 34px 15px">
                            {{-- <div style="margin-bottom: 10px">
                                <a href="https://keenthemes.com" rel="noopener" target="_blank">
                                    <img alt="Logo" src="assets/media/email/logo-1.svg" style="height: 35px" />
                                </a>
                            </div> --}}
                            <div style="margin-bottom: 15px">
                                <img alt="Logo" src="https://res.cloudinary.com/duuawbwih/image/upload/v1726807829/teacher_u8b4cb.png" width="100" height="100" />
                            </div>
                            <div
                                style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">
                                    Halo, {{ $mailData['nama'] }} kamu telah diundang oleh dosen <br> {{ $mailData['dosen'] }}
                                </p>
                                <p style="margin-bottom:2px; color:#7E8299"> Kamu telah diundang untuk bergabung dalam kelas
                                    {{ $mailData['nama_kelas'] }} 
                                </p>
                                <p style="margin-bottom:4px; color:#7E8299"> pada mata kuliah {{ $mailData['matakuliah'] }}.
                                </p>
                            </div>
                            <a href='{{ route("mahasiswa.kelas.show", $mailData["kode_kelas"])}}' target="_blank"
                                style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">
                                Masuk Kelas
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="center"
                        style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                        <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px">
                            Ayo Belajar Bersama Tutor Cerdas
                        </p>
                        {{-- <p style="margin-bottom:2px">Call our customer care number: +31 6 3344 55 56</p>
                        <p style="margin-bottom:4px">You may reach us at
                            <a href="https://devs.keenthemes.com" rel="noopener" target="_blank"
                                style="font-weight: 600">devs.keenthemes.com</a>.
                        </p>
                        <p>We serve Mon-Fri, 9AM-18AM</p> --}}
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="center"
                        style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                        <p>&copy; Copyright Tutor Cerdas.
                            Kunjungi kami di
                            <a href="{{ route("home") }}" rel="noopener" target="_blank"
                                style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Sini</a>&nbsp;.
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
