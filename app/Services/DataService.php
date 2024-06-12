<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Session\SessionManager;

class DataService
{
    public function getMenuHTML($menu_aktif, SessionManager $session)
    {
        // $id_role = '1';
        $id_role = $session->get('id_role');

        $pecah_menu_aktif = explode("||", $menu_aktif);
        // dd($pecah_menu_aktif[1]);

        $menus = DB::select("SELECT B.* FROM apps_akses_menu A inner join apps_menu B on A.menu_id = B.id_menu WHERE B.status_menu ='Y' and B.is_master in('E','Y') and A.role_id =" . $id_role . " order by B.urutan ASC");
        $html = '';
        foreach ($menus as $menu) {

            if ($menu->is_master == 'Y') {
                if ($pecah_menu_aktif[1] == $menu->url) {
                    $html .= '<div data-kt-menu-trigger="{default: \'click\', lg: \'hover\'}" data-kt-menu-placement="bottom-start" class="menu-item here show menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                            <span class="menu-link">
                                <span class="menu-title" style="color:#f6c000;">' . $menu->nama_menu . '</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </span>
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">';
                } else {
                    $html .= '<div data-kt-menu-trigger="{default: \'click\', lg: \'hover\'}" data-kt-menu-placement="bottom-start" class="menu-item here show menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                            <span class="menu-link">
                                <span class="menu-title">' . $menu->nama_menu . '</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </span>
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">';
                }

                $submenu = DB::select("SELECT B.* FROM apps_akses_menu A inner join apps_menu B on A.menu_id = B.id_menu WHERE B.status_menu ='Y' and B.is_master in('N') and B.master_menu = '" . $menu->id_menu . "' and A.role_id =" . $id_role . "");
                foreach ($submenu as $child) {
                    if ($pecah_menu_aktif[0] == $child->url) {
                        $html .= '<div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" href="' . $child->url . '">
                                    <span class="menu-icon">
                                    ' . $child->icon . '
                                    </span>
                                    <span class="menu-title" style="color:#1b84ff;">' . $child->nama_menu . '</span>
                                </a>
                                <!--end:Menu link-->
                            </div>';
                    } else {
                        $html .= '<div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" href="' . $child->url . '">
                                    <span class="menu-icon">
                                    ' . $child->icon . '
                                    </span>
                                    <span class="menu-title">' . $child->nama_menu . '</span>
                                </a>
                                <!--end:Menu link-->
                            </div>';
                    }
                }
                $html .= '</div></div>';
            } else {
                if ($pecah_menu_aktif[0] == $menu->url) {
                    $html .= '<div class="menu-item here show menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                            <a href="' . $menu->url . '" >
                                <span class="menu-link">
                                    <span class="single-menu" style="color:#f6c000;">' . $menu->nama_menu . '</span>
                                    <span class="menu-arrow d-lg-none"></span>
                                </span>
                            </a>
                        </div>';
                } else {
                    $html .= '<div class="menu-item here show menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                            <a href="' . $menu->url . '" >
                                <span class="menu-link">
                                    <span class="single-menu">' . $menu->nama_menu . '</span>
                                    <span class="menu-arrow d-lg-none"></span>
                                </span>
                            </a>
                        </div>';
                }
            }
        }

        return $html;
    }
}
