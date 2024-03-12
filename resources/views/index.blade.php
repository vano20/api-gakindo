<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <link href="storage/fonts/Arimo-VariableFont_wght" rel="stylesheet">
    <link href="storage/fonts/Arimo-Italic-VariableFont_wght" rel="stylesheet">
    <style>
      @page { margin: 0; }
      @font-face {
        font-family: 'Arimo';
        src: url({{ storage_path("fonts/Arimo-Regular.ttf") }}) format("truetype");
        font-weight: 400;
        font-style: normal;
      }
      @font-face {
        font-family: 'Arimo';
        src: url({{ storage_path("fonts/Arimo-Italic.ttf") }}) format("truetype");
        font-weight: 400;
        font-style: italic;
      }
      @font-face {
        font-family: 'Arimo';
        src: url({{ storage_path("fonts/Arimo-Medium.ttf") }}) format("truetype");
        font-weight: 500;
        font-style: normal;
      }
      @font-face {
        font-family: 'Arimo';
        src: url({{ storage_path("fonts/Arimo-SemiBold.ttf") }}) format("truetype");
        font-weight: 600;
        font-style: normal;
      }
      @font-face {
        font-family: 'Arimo';
        src: url({{ storage_path("fonts/Arimo-SemiBoldItalic.ttf") }}) format("truetype");
        font-weight: 600;
        font-style: italic;
      }
      @font-face {
        font-family: 'Roboto';
        src: url({{ storage_path("fonts/Roboto-Bold.ttf") }}) format("truetype");
        font-weight: 900;
        font-style: normal;
      }
      body {
        border: 34px solid #C9C9C9;
        /* padding: 10px; */
      }
      .header {
        position: absolute;
        right: 50%;
        transform: translate(50%, 0);
        padding-top: 20px;
      }
      .header > .title {
        text-align: center;
      }
      .header > .membership {
        margin-left: 72px;
        margin-top: 8px;
      }
      .arimo {
        font-family: Arimo, arial, Helvetica, sans-serif;
      }
      .field {
        display: block;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 6px;
      }
      .sub-field {
        display: block;
        font-size: 15px;
        line-height: 0;
        font-style: italic;
      }
      .space-td {
        padding-top: 8px;
      }
      .floating-period {
        position: absolute;
        right: 50%;
        top: 50%;
        transform: translate(50%, -50%);
        z-index: -1;
      }
      .floating-period h1 {
        /* margin: 0;
        letter-spacing: -32px;
        font-weight: 900;
        font-size: 152px;
        font-family: Roboto;
        background: linear-gradient(to right, #f8f8f8, #dfe0e0);
        -webkit-text-fill-color: transparent;
        -webkit-background-clip: text; */
      }
      .semi-bold {
        font-weight: 600;
      }
      .colons {
        padding-left: 30px;
        font-weight: 300;
      }
      .field-value {
        padding-left: 25px;
      }
      .position {
        font-size: 8px;
        text-transform: capitalize;
      }
    </style>
    </head>
    <body>
      <div class="floating-period">
        <img src="assets/{{$currentYear}}.png" height="172" />
      </div>
      <!-- Header -->
      <div class="header">
        <img src="https://gakindo.org/wp-content/uploads/2021/07/Gabungan-Kontraktor-Indonesia.jpg" height="80" style="margin-bottom: 5px" />
        <div class="title" style="text-align: center;">
          <h2 style="font-weight: 500; line-height: 0.1; margin-bottom: 14px;">KARTU TANDA ANGGOTA</h2>
          <div class="arimo" style="font-size: x-small; line-height: 0;"><i>Certificate of Ordinary Member</i></div>
        </div>
        <div class="membership">
            <div class="arimo" style="font-size: 14px; margin-bottom: 14px;">
              No. Anggota
              <span>{{$membership_id}}</span>
            </div>
            <div class="arimo" style="font-size: x-small; line-height: 0;"><i>Membership Nr.</i></div>
        </div>
      </div>
      <!-- Form -->
      <div class="arimo" style="margin-top: 200px; margin-left: 100px;">
        <table>
          <tbody>
            <!-- company_name -->
            <tr>
              <td>
                <span class="field">Nama Badan Usaha</span>
              </td>
              <td class="colons">:</td>
              <td class="field-value">{{$company_name}}</td>
            </tr>
            <tr>
              <td>
                <span class="sub-field">Name of Company</span>
              </td>
            </tr>
            <!-- contact_person -->
            <tr>
              <td class="space-td">
                <span class="field">Penanggung Jawab</span>
              </td>
              <td class="colons">:</td>
              <td class="field-value">{{$contact_person}}</td>
            </tr>
            <tr>
              <td>
                <span class="sub-field">Contact Person</span>
              </td>
            </tr>
            <!-- position -->
            <tr>
              <td class="space-td">
                <span class="field">Jabatan</span>
              </td>
              <td class="colons">:</td>
              <td class="field-value">{{$position}}</td>
            </tr>
            <tr>
              <td>
                <span class="sub-field">Position</span>
              </td>
            </tr>
            <!-- company_address -->
            <tr>
              <td class="space-td">
                <span class="field">Alamat Badan Usaha</span>
              </td>
              <td class="colons">:</td>
              <td class="field-value" style="text-transform: capitalize;">{{$company_address}}</td>
            </tr>
            <tr>
              <td>
                <span class="sub-field">Company Address</span>
              </td>
            </tr>
            <!-- npwp -->
            <tr>
              <td class="space-td">
                <span class="field" style="letter-spacing: 8px;">NPWP</span>
              </td>
              <td class="colons">:</td>
              <td class="field-value">{{$npwp}}</td>
            </tr>
            <tr>
              <td>
                <span class="sub-field">Tax Registration Number</span>
              </td>
            </tr>
            <!-- qualification -->
            <tr>
              <td class="space-td">
                <span class="field">Kualifikasi</span>
              </td>
              <td class="colons">:</td>
              <td class="field-value">{{$qualification}}</td>
            </tr>
            <tr>
              <td>
                <span class="sub-field">Qualification</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Statement -->
      <div class="arimo" style="text-align: center; margin-bottom: 14px;">
        <div class="semi-bold" style="font-size: 20px; margin-bottom: 12px;">
          Adalah Anggota Biasa Gabungan Kontraktor Indonesia
        </div>
        <div class="arimo" style="font-size: small; line-height: 0;">
          <i>Is Ordinary Member of Indonesian Contractor Association</i>
        </div>
      </div>
      <!-- Signature -->
      <div style="text-align: center">
        <div class="arimo" style="text-transform: uppercase; font-size: 12px; margin-bottom: 6px; line-height: 0.8;">
          badan pengurus pusat gabungan kontraktor indonesia<br />
          (GAKINDO)
        </div>
        <div class="arimo position">
          <i>head exceutive board</i>
        </div>
        <div class="qrcode">
          <img src="assets/qrcode_generated.png" height="72px" />
        </div>
        <div class="arimo semi-bold" style="font-size: 12px; margin-top: 16px; line-height: 0.4;">
          Ketua Umum
        </div>
        <div class="arimo position" style="margin-bottom: 10px;">
          <i>president</i>
        </div>
        <div class="arimo semi-bold" style="line-height: 1; font-size: 12px;">
          Berlaku Sampai 31 Desember {{$currentYear}}
        </div>
        <div class="arimo" style="font-size: 10px; text-transform: capitalize">
          <i>valid until December 31, {{$currentYear}}</i>
        </div>
      </div>
    </body>
</html>
