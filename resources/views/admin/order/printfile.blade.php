

<?php
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<head>
    <style>
        body{
            font-size: 14px;
            font-family: Arial;
            color: black;
            border: 3px solid;
            padding: 10px;
            
        }
    </style>
</head>
<body>
    <div class="clear" style="height: 20px;"></div>
        <h2 align="center">
            <?php if(isset($setting)) echo $setting->company_name;?>
        </h2>
        <p align="center">
            <?php if(isset($setting)) echo $setting->company_address;?>
        </p>
        <p style="font-style: italic;" width="100%" align="center">
            Điện thoại :<?php if(isset($setting)) echo $setting->company_hotline;?>&emsp; Email :<?php if(isset($setting)) echo $setting->company_email;?>&emsp; Website :<?php if(isset($setting)) echo $setting->company_website_url;?>
        </p>          

        <div class="clear" style="height: 20px;"></div>
            <h1 align="center">HÓA ĐƠN BÁN HÀNG</h1>
        <div class="clear" style="height: 20px;"></div>
        <table width="100%" cellpadding="3" cellspacing="1">    
            <tr>
                <td>Người mua hàng :</td>
                <td>
                    <?php if(isset($printfile)) echo $printfile->name;?>												
                </td>
                <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</td>
            </tr>				
            <tr>
                <td>Email :</td>
                <td>
                    <?php if(isset($printfile)) echo $printfile->email;?>												
                </td>
            </tr>					
            <tr>
                <td>Địa chỉ :</td>
                <td>
                    <?php if(isset($printfile)) echo $printfile->address;?>												
                </td>
            </tr>							
            <tr>
                <td>Điện thoại :</td>
                <td>
                    <?php if(isset($printfile)) echo $printfile->phone;?>												
                </td>
            </tr>				
            <tr>
                <td>Nội dung :</td>
                <td>
                    <?php if(isset($printfile)) echo $printfile->content;?>												
                </td>
            </tr>				
        </table>
        <div class="clear" style="height: 20px;"></div>
        <table cellspacing="1" cellpadding="5" width="99%" style="font-size: 12px" border="1" >
            <tbody>
                <tr>
                    <th>STT</th>
                    <th>Mã SP</th>
                    <th>Tên sản phẩm</th> 
                    <th>Đơn vị</th>  
                    <th>Số lượng</th>  
                    <th>Đơn Giá</th>  
                    <th>Thành tiền</th>            
                </tr>
            </tbody>
        </table>
        <div class="clear" style="height: 20px;"></div>
        <table width="100%" cellpadding="3" cellspacing="1">
            <tr>
                <td style="padding-left:100px;">
                    <p>Người mua hàng</p>
                    <small style="line-height: 0;font-style: italic;padding-left:10px;">Ký,ghi rõ họ tên</small>
                </td>
                <td align="right" style="padding-right:100px;">
                    <p>Người bán hàng</p>
                    <small style="line-height: 0;font-style: italic;padding-right:10px;">Ký,ghi rõ họ tên</small>
                </td>
            </tr>
        </table>
</body>

