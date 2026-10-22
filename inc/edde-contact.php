<?php
/**
 * Saytın vahid əlaqə məlumatları. Header, footer, Əlaqə səhifəsi, düymələr və formalar
 * nömrə/ünvanı yalnız buradan oxuyur — dəyişmək üçün bu faylı redaktə etmək kifayətdir.
 */

if (!function_exists('edde_contact')) {
  function edde_contact() {
    return [
      // [göstərilən mətn, tel: üçün nömrə]
      'phones' => [
        ['+994 77 255 56 58', '+994772555658'],
        ['+994 70 833 20 04', '+994708332004'],
        ['+994 12 409 67 89', '+994124096789'],
      ],
      'whatsapp'         => '994708332004',
      'whatsapp_display' => '+994 70 833 20 04',
      'email'            => 'info@eddeglobal.az',
      'address'          => 'Əliyar Əliyev 61, N.Nərimanov ray., Bakı, AZ1052',
      'map_query'        => 'Əliyar Əliyev 61, Nərimanov, Bakı',
      'test_url'         => 'https://test.eddeglobal.az',
    ];
  }
}

if (!function_exists('edde_wa_url')) {
  /** WhatsApp ünvanı; istəyə görə hazır mesaj mətni ilə. */
  function edde_wa_url($text = '') {
    $c = edde_contact();
    return 'https://wa.me/' . $c['whatsapp'] . ($text !== '' ? '?text=' . rawurlencode($text) : '');
  }
}
