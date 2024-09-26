<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Events\DiskusiGrupCreated;
use App\Events\DiskusiPribadiCreated;
use App\Http\Controllers\Controller;
use App\Models\DiskusiGrup;
use App\Models\DiskusiPribadi;
use App\Models\KelasMahasiswa;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Http;

class MateriController extends Controller
{
    public function materi($kode_kelas, $id)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with('kelas')->first();
        $data = [
            'title' => 'Materi',
            'menu' => 'kelas',
            'sub_menu' => 'materi',
            'kode_kelas' => $kode_kelas,
            'materi_id' => $id,
            'materi' => $materi,
            'list_mahasiswa' => KelasMahasiswa::where('kode_kelas', $kode_kelas)->with('mahasiswa')->where('status', 'aktif')->get(),
            'list_diskusi_grup' => DiskusiGrup::where('materi_id', $id)->orderBy('created_at', 'asc')->with('user')->get()
        ];
        // return response()->json($data);
        return view('pages.mahasiswa.materi.show', $data);
    }

    public function kirimDiskusiGrup(Request $request, $materi_id)
    {
        $diskusi_grup = DiskusiGrup::create([
            'materi_id' => $materi_id,
            'user_id' =>  Auth::user()->id,
            'pesan' => $request->pesan
        ]);

        Broadcast(new DiskusiGrupCreated(
            $diskusi_grup->load('user')
        ))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan berhasil dikirim',
            'data' => $diskusi_grup->load('user')
        ]);
    }

    public function materiDiskusiPribadi($kode_kelas, $id)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with('kelas')->first();
        $data = [
            'title' => 'Materi',
            'menu' => 'kelas',
            'sub_menu' => 'materi',
            'kode_kelas' => $kode_kelas,
            'materi_id' => $id,
            'materi' => $materi,
            'list_mahasiswa' => KelasMahasiswa::where('kode_kelas', $kode_kelas)->with('mahasiswa')->where('status', 'aktif')->get(),
            'list_diskusi_pribadi' => DiskusiPribadi::where('user_chat_id', Auth::user()->id)->where('materi_id', $id)->orderBy('created_at', 'asc')->with('user')->get()
        ];
        // return response()->json($data);
        return view('pages.mahasiswa.materi.diskusi-pribadi', $data);
    }

    public function kirimDiskusiPribadi(Request $request, $materi_id)
    {
        $diskusi_pribadi = DiskusiPribadi::create([
            'materi_id' => $materi_id,
            'user_id' =>  Auth::user()->id,
            'user_chat_id' => Auth::user()->id,
            'pesan' => $request->pesan
        ]);

        Broadcast(new DiskusiPribadiCreated(
            $diskusi_pribadi->load('user')
        ))->toOthers();

        $responseChatbot = null;
        try {
            $response = Http::post('http://127.0.0.1:4000/chatbot', [
                'materi_id' => $materi_id,
                'user_id' => Auth::user()->id,
                'user_chat_id' => Auth::user()->id,
                'query' => $request->pesan
            ]);

            $responseChatbot = $response['response']['result'];

            DiskusiPribadi::create([
                'materi_id' => $materi_id,
                // 'user_id' =>  0,
                'user_chat_id' => Auth::user()->id,
                'is_ai' => true,
                'pesan' => $response['response']['result']
            ]);
            
        } catch (\Throwable $th) {
            $responseChatbot = null;
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Pesan berhasil dikirim',
            'data' => $diskusi_pribadi->load('user'),
            'response_chatbot' => $responseChatbot
        ]);
    }

    public function testKirimDiskusiPribadi(Request $request, $materi_id)
    {

        $response = Http::post('http://127.0.0.1:4000/chatbot', [
            'materi_id' => $materi_id,
            'user_id' => 4,
            'user_chat_id' => 4,
            'query' => $request->pesan
        ]);

        $diskusi = DiskusiPribadi::create([
            'materi_id' => $materi_id,
            // 'user_id' =>  0,
            'user_chat_id' => 4,
            'is_ai' => true,
            'pesan' => $response['response']['result']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan berhasil dikirim',
        ]);


    }
}
