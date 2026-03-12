<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HowToPlay;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SettingController extends Controller
{
    public function main()
    {
        $settings = Setting::pluck('setting_value', 'setting_key');
        return view('admin.settings.main', compact('settings'));
    }

    public function updateMain(Request $request)
    {
        $request->validate([
            'site_name'            => 'nullable|string|max:100',
            'min_recharge'         => 'required|numeric|min:1',
            'max_recharge'         => 'required|numeric|min:1',
            'min_withdraw'         => 'required|numeric|min:1',
            'max_withdraw'         => 'required|numeric|min:1',
            'announcement_title'   => 'nullable|string|max:255',
            'announcement_message' => 'nullable|string|max:1000',
            'announcement_status'  => 'nullable|in:0,1',
        ]);

        $keys = ['site_name','min_recharge','max_recharge','min_withdraw','max_withdraw',
                 'announcement_title','announcement_message','announcement_status'];
        foreach ($keys as $key) {
            Setting::updateOrCreate(['setting_key' => $key], ['setting_value' => $request->$key ?? '']);
        }
        return response()->json(['status' => true, 'message' => 'Settings saved successfully']);
    }

    public function contact()
    {
        $settings = Setting::pluck('setting_value', 'setting_key');
        return view('admin.settings.contact', compact('settings'));
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'support_whatsapp_1' => 'nullable|string|max:20',
            'support_whatsapp_2' => 'nullable|string|max:20',
            'support_call'       => 'nullable|string|max:20',
            'support_telegram'   => 'nullable|string|max:255',
        ]);
        $keys = ['support_whatsapp_1','support_whatsapp_2','support_call','support_telegram'];
        foreach ($keys as $key) {
            Setting::updateOrCreate(['setting_key' => $key], ['setting_value' => $request->$key ?? '']);
        }
        return response()->json(['status' => true, 'message' => 'Contact settings saved']);
    }

    public function how_to_play()
    {
        $steps = Schema::hasTable('how_to_play')
            ? HowToPlay::orderBy('display_order')->get()
            : collect();
        return view('admin.settings.how_to_play', compact('steps'));
    }

    public function storeHowToPlay(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        HowToPlay::create([
            'title'         => $request->title,
            'content'       => $request->content,
            'video_url'     => $request->video_url,
            'display_order' => $request->display_order ?? 0,
            'is_active'     => $request->is_active ?? 1,
        ]);
        return response()->json(['status' => true, 'message' => 'Step added']);
    }

    public function updateHowToPlay(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        HowToPlay::findOrFail($id)->update([
            'title'         => $request->title,
            'content'       => $request->content,
            'video_url'     => $request->video_url,
            'display_order' => $request->display_order ?? 0,
            'is_active'     => $request->is_active ?? 1,
        ]);
        return response()->json(['status' => true, 'message' => 'Step updated']);
    }

    public function destroyHowToPlay($id)
    {
        HowToPlay::findOrFail($id)->delete();
        return response()->json(['status' => true, 'message' => 'Step deleted']);
    }

    public function clear_data()    { return view('admin.settings.main'); }
    public function slider_images() { return view('admin.settings.main'); }
}
