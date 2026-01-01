<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Matka Play | Add Fund Manual</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        /* ✅ FIXED TOP BAR */
        .top-bar {
            position: fixed;
            top: 0;
            width: 100%;
            max-width: 500px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 25px;
            border-bottom: 1px solid #eee;
            background: #fff;
            z-index: 10;
        }

        .top-bar i {
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 20px;
            background: #007bff;
            color: #fff;
        }

        .wallet {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #007bff;
        }

        /* ✅ SCROLLABLE AREA */
        .home-content {
            flex: 1;
            overflow-y: auto;
            background: #f5f6fa;
            padding: 90px 15px 100px;
            height: calc(100vh - 140px);
        }

        /* ✅ ADD FUND MANUAL SECTION */
        .fund-container {
            max-width: 480px;
            margin: 0 auto;
            text-align: center;
        }

        .fund-container p {
            font-size: 14px;
            color: #444;
            text-align: left;
            font-weight: 500;
        }

        /* ✅ INPUT FIELDS */
        .input-wrapper {
            position: relative;
            margin-top: 15px;
        }

        .form-control-custom {
            width: 100%;
            border: none;
            border-radius: 30px;
            background: #f8f9fb;
            padding: 12px 45px 12px 18px;
            font-size: 15px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .input-wrapper i {
            position: absolute;
            right: 18px;
            top: 12px;
            color: #999;
            font-size: 16px;
        }

        /* ✅ OR LINE */
        .or-divider {
            margin: 20px 0;
            text-align: center;
            color: #007bff;
            font-weight: 600;
            font-size: 14px;
        }

        /* ✅ UPLOAD AREA */
        .upload-box {
            background: #fff;
            border: 1px dashed #bbb;
            border-radius: 10px;
            padding: 30px 15px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .upload-box:hover {
            border-color: #007bff;
            background: #f9fbff;
        }

        .upload-box i {
            font-size: 50px;
            color: #aaa;
        }

        /* ✅ SUBMIT BUTTON */
        .submit-btn {
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 25px;
            width: 100%;
            padding: 12px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 3px 6px rgba(0, 123, 255, 0.3);
            transition: 0.3s;
            margin-top: 25px;
        }

        .submit-btn:hover {
            background: #0056d2;
        }

     
    </style>
</head>

<body>

    <div class="app-layout">
        <div class="left-area">
        <div class="top-bar">
            <i class="fa-solid fa-angle-left" onclick="goBack()"></i>
            <h5 class="m-0 fw-bold text-primary">Add Fund Manual</h5>
            @include('components.walletinfo')
        </div>

        <div class="home-content">
            <div class="fund-container">
                <p>Upload the payment screenshot (with UTR number) and submit</p>

                <div class="input-wrapper">
                    <input type="number" class="form-control-custom" placeholder="Enter Amount">
                    <i class="fa-solid fa-indian-rupee-sign"></i>
                </div>

                <div class="input-wrapper">
                    <input type="text" class="form-control-custom" placeholder="Enter UTR Number">
                    <i class="fa-solid fa-hashtag"></i>
                </div>

                <div class="or-divider">OR</div>

                <div class="upload-box" onclick="document.getElementById('uploadInput').click();">
                    <i class="fa-solid fa-image"></i>
                    <input type="file" id="uploadInput" style="display:none;" accept="image/*">
                </div>

                <button class="submit-btn">SUBMIT</button>
            </div>
        </div>

        <!-- Bottom Bar -->
        @include('components.bottombar')
        </div>

        @include('components.rightside')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    {{-- toastify --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

</body>

</html>
