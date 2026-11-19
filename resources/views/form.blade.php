<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#e9edfb">
    <title>فروشگاه قطعات خودرو | کاتالوگ محصولات</title>

    <style>
        @font-face{font-family:'YekanBakh';src:url('assets/YekanBakh-Regular.woff') format('woff');font-weight:400;font-style:normal;font-display:swap}
        @font-face{font-family:'YekanBakh';src:url('assets/YekanBakh-Bold.woff') format('woff');font-weight:700;font-style:normal;font-display:swap}

        :root{
            --bg:#e9edfb;--surface:#ffffff;--surface-soft:#f3f5fd;--surface-soft-2:#eaeefb;--surface-sunken:#e0e6f7;
            --ink:#161a2e;--muted:#5b6482;--blue:#4361ee;--blue-soft:#e3e8ff;--green:#0fa968;--red:#e5384f;
            --radius:16px;--ease:cubic-bezier(.2,.8,.2,1);
            --grad-main:linear-gradient(135deg,#4361ee 0%,#7c4dff 100%);
            --grad-green:linear-gradient(135deg,#0fa968 0%,#14c8a0 100%);
            --grad-red:linear-gradient(135deg,#e5384f 0%,#ff6b6b 100%);
            --grad-warm:linear-gradient(135deg,#ff5d73 0%,#ff9248 100%);
            --grad-gold:linear-gradient(135deg,#f7b733 0%,#fc4a1a 100%);
        }
        *{box-sizing:border-box}
        html{-webkit-text-size-adjust:100%;text-size-adjust:100%}
        body{
            margin:0;background:var(--bg);color:var(--ink);
            font-family:'YekanBakh',-apple-system,BlinkMacSystemFont,"Segoe UI",Tahoma,Arial,sans-serif;
            font-size:14px;line-height:1.65;
            touch-action:manipulation;
            -webkit-tap-highlight-color:transparent;
        }
        img{max-width:100%;height:auto;display:block;-webkit-user-drag:none;user-select:none;-webkit-touch-callout:none}
        button,input,select{font:inherit;font-family:'YekanBakh',sans-serif}
        button{cursor:pointer}
        :focus-visible{outline:3px solid #f2a100;outline-offset:2px}
        .app{max-width:1440px;margin:auto;padding:14px 26px 40px;position:relative}
        #stickySentinel{position:absolute;top:0;left:0;width:1px;height:1px;pointer-events:none;visibility:hidden}

        .toolbar-wrap{
            position:sticky;top:0;z-index:15;
            padding:10px 0 8px;margin:0 -6px 8px;
            background:linear-gradient(var(--bg) 78%,transparent);
            transition:background .25s;
        }
        .toolbar-wrap.stuck{background:rgba(233,237,251,.92);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px)}
        .toolbar{background:var(--surface);border-radius:var(--radius);padding:12px 14px;box-sizing:border-box}

        .searchline{display:flex;gap:7px;margin-bottom:11px;align-items:center}
        .searchbox{position:relative;flex:1;min-width:0}
        .searchbox svg.search-icon{position:absolute;right:14px;top:50%;transform:translateY(-50%);color:var(--blue);pointer-events:none}
        .searchbox input{width:100%;height:42px;border:0;border-radius:11px;background:var(--surface-soft);padding:0 40px 0 13px;outline:none;font-size:14px;transition:background .2s,box-shadow .2s}
        .searchbox input::placeholder{color:#7c86a5}
        .searchbox input:focus{background:#fff;box-shadow:0 0 0 3px rgba(67,97,238,.18)}

        .quick-actions{display:flex;gap:7px;flex:none;align-items:center}
        .quick-btn{width:42px;height:42px;border:0;border-radius:11px;background:var(--surface-soft);color:#3a4580;display:inline-flex;align-items:center;justify-content:center;position:relative;transition:background .2s,color .2s;padding:0;text-decoration:none}
        .quick-btn:hover{background:var(--blue-soft);color:var(--blue)}
        .quick-btn svg{flex:none}
        .quick-btn .badge{position:absolute;top:-6px;left:-6px;min-width:19px;height:19px;font-size:10px;border-radius:6px;padding:0 4px;color:#fff;display:inline-flex;align-items:center;justify-content:center;line-height:1}
        .quick-btn .cart-count{background:var(--grad-warm)}
        .quick-btn .order-count{background:var(--grad-main)}

        .logo-btn{display:inline-flex;align-items:center;justify-content:center;padding:0;background:transparent;border:0;flex:none;width:42px;height:42px;pointer-events:none}
        .logo-btn img{width:100%;height:100%;object-fit:contain;display:block}

        /* ---------- منوی پروفایل ---------- */
        .profile-menu{
            position:fixed;top:64px;left:22px;min-width:280px;
            background:#fff;border-radius:14px;z-index:150;
            box-shadow:0 12px 34px rgba(23,35,58,.18);
            opacity:0;transform:translateY(-6px);pointer-events:none;transition:opacity .18s,transform .18s;
            display:none;
        }
        .profile-menu.show{display:block;opacity:1;transform:translateY(0);pointer-events:auto}
        .profile-menu-head{padding:14px 14px 10px;background:var(--surface-soft);border-radius:14px 14px 0 0}
        .profile-menu-name{display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--ink)}
        .profile-menu-name .avatar{width:38px;height:38px;border-radius:50%;background:var(--grad-main);color:#fff;display:inline-flex;align-items:center;justify-content:center;flex:none}
        .profile-menu-name .avatar svg{width:20px;height:20px}
        .profile-menu-name .name-text{font-weight:700;font-size:13px;line-height:1.4}
        .profile-menu-name .name-text small{display:block;color:var(--muted);font-weight:400;font-size:10.5px}
        .profile-menu-name:hover .name-text{color:var(--blue)}
        .profile-club{display:flex;align-items:center;gap:8px;margin-top:10px;padding:9px 10px;background:linear-gradient(135deg,#fff7e0,#ffe9bd);border-radius:10px;text-decoration:none;color:#7a4a00;transition:filter .18s}
        .profile-club:hover{filter:brightness(.97)}
        .profile-club .star{width:26px;height:26px;flex:none;color:#f5a623;filter:drop-shadow(0 1px 1px rgba(245,166,35,.4))}
        .profile-club .club-text{font-size:11.5px;line-height:1.35}
        .profile-club .club-text b{font-size:13px;color:#8a4b00}
        .profile-club .club-arrow{margin-right:auto;color:#b07a2a;flex:none}

        /* کارت اعتبار خرید (نارنجی) */
        .profile-credit{
            display:flex;align-items:center;gap:8px;
            margin-top:8px;padding:9px 10px;
            background:linear-gradient(135deg,#ffe4cc,#ffd0a1);
            border-radius:10px;
            text-decoration:none;color:#7a3b00;
            transition:filter .18s;
        }
        .profile-credit:hover{filter:brightness(.97)}
        .profile-credit .wallet-icon{width:26px;height:26px;flex:none;color:#c2570a;filter:drop-shadow(0 1px 1px rgba(194,87,10,.4))}
        .profile-credit .credit-text{font-size:11.5px;line-height:1.35;min-width:0;flex:1}
        .profile-credit .credit-text small{display:block;font-size:10px;color:#a35a1a;font-weight:700;margin-bottom:1px}
        .profile-credit .credit-text .credit-max{font-size:11px;color:#a35a1a;font-weight:700}
        .profile-credit .credit-text .credit-max b{font-size:11.5px;color:#8a3c00}
        .profile-credit .credit-text .credit-current{font-size:14px;color:#8a3c00;font-weight:700;display:block;margin-top:1px}
        .profile-credit .credit-text .credit-current span{font-size:10px;color:#a35a1a;font-weight:700;margin-right:3px}
        .profile-credit .credit-arrow{margin-right:auto;color:#c2570a;flex:none}

        .profile-menu-items{list-style:none;margin:0;padding:6px;display:flex;flex-direction:column;gap:2px}
        .profile-menu-items a,.profile-menu-items button{display:flex;align-items:center;gap:10px;width:100%;padding:9px 10px;border:0;background:transparent;color:var(--ink);border-radius:9px;font-size:12.5px;text-decoration:none;text-align:right;transition:background .15s,color .15s}
        .profile-menu-items a:hover,.profile-menu-items button:hover{background:var(--blue-soft);color:var(--blue)}
        .profile-menu-items svg{width:17px;height:17px;flex:none;color:var(--muted)}
        .profile-menu-items a:hover svg,.profile-menu-items button:hover svg{color:var(--blue)}
        .profile-menu-items .divider{height:1px;background:var(--surface-soft-2);margin:4px 8px;border-radius:2px}

        .filters{display:grid;grid-template-columns:1.05fr 1fr 1fr 1fr 1.15fr auto;gap:8px;align-items:end}
        .field label{display:block;color:var(--muted);font-size:11px;font-weight:700;margin:0 0 4px 3px}
        .field{position:relative}
        .custom-select{position:relative;user-select:none}
        .custom-select-trigger{width:100%;height:36px;border:0;border-radius:9px;background:var(--surface-soft);padding:0 10px;color:var(--ink);outline:none;display:flex;align-items:center;justify-content:space-between;cursor:pointer;transition:background .2s,box-shadow .2s}
        .custom-select-trigger span{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:13px;color:var(--ink)}
        .custom-select-trigger span.placeholder{color:#7c86a5}
        .custom-select-trigger svg{flex:none;color:var(--blue);transition:transform .2s}
        .custom-select.open .custom-select-trigger svg{transform:rotate(180deg)}
        .custom-select.open .custom-select-trigger,.custom-select-trigger:focus{background:#fff;box-shadow:0 0 0 3px rgba(67,97,238,.18)}
        .custom-options{position:absolute;top:calc(100% + 4px);left:0;right:0;background:#fff;border-radius:10px;z-index:100;display:none;max-height:200px;flex-direction:column;overflow:hidden;box-shadow:0 10px 30px rgba(23,35,58,.10)}
        .custom-select.open .custom-options{display:flex}
        .custom-options-search{padding:8px;background:var(--surface-soft);flex:none}
        .custom-options-search input{width:100%;height:32px;border:0;border-radius:6px;background:#fff;padding:0 8px;font-size:12px;outline:none}
        .custom-options-search input:focus{box-shadow:0 0 0 2px rgba(67,97,238,.2)}
        .custom-options-list{overflow-y:auto;padding:4px;flex:1}
        .custom-option{padding:8px 10px;font-size:12px;border-radius:6px;cursor:pointer;transition:background .1s;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .custom-option:hover{background:var(--surface-soft)}
        .custom-option.selected{background:var(--grad-main);color:#fff;font-weight:700}
        .custom-option.empty{padding:12px;text-align:center;color:#8f97b5;cursor:default;background:transparent!important;}
        .sort-select-wrapper{position:relative;width:100%;height:36px}
        .sort-select-wrapper .custom-select-trigger{position:absolute;top:0;left:0;right:0}
        .toggle-field{height:36px;display:flex;align-items:center;gap:9px;padding:0 10px;border:0;border-radius:9px;white-space:nowrap;background:var(--surface-soft);font-size:12px;font-weight:700}
        .switch{appearance:none;width:34px;height:20px;border-radius:20px;background:#c8d0ea;position:relative;outline:none;transition:background .2s;flex:none}
        .switch:before{content:"";position:absolute;width:14px;height:14px;top:3px;right:3px;border-radius:50%;background:#fff;transition:transform .2s var(--ease)}
        .switch:checked{background:var(--grad-main)}
        .switch:checked:before{transform:translateX(-14px)}
        .reset{height:36px;border:0;background:transparent;color:#ff6b6b;padding:0 10px;font-size:12px;font-weight:700;text-decoration:underline}
        .reset:hover{color:#e5384f}

        .list-head{display:flex;justify-content:space-between;align-items:center;padding:3px 4px 8px;color:var(--muted);font-size:12px}
        .list-head strong{color:var(--ink)}
        .products{display:flex;flex-direction:column;gap:8px}

        .product{position:relative;background:var(--surface);border:0;border-radius:var(--radius);padding:13px 16px;display:grid;grid-template-columns:minmax(210px,1.5fr) minmax(150px,.85fr) auto;gap:14px;align-items:center;transition:background .22s}
        .product:hover{background:#fbfcff}
        .product.in-cart{background:linear-gradient(to left,#e9faf2 0%,#fff 42%)}
        .product.out-of-stock{background:linear-gradient(to left,#fdeef0 0%,#fbf8fa 42%)}
        .product-main{min-width:0}
        .copy-btn{width:22px;height:22px;border:0;border-radius:6px;background:var(--blue-soft);color:var(--blue);display:inline-flex;align-items:center;justify-content:center;padding:0;flex:none;transition:background .18s,color .18s}
        .copy-btn:hover{background:var(--blue);color:#fff}
        .copy-btn svg{flex:none}
        .product-title{font-size:15px;font-weight:700;line-height:1.5;margin-bottom:0;color:#12163a}
        .tags{display:flex;flex-wrap:wrap;gap:5px;margin-top:7px}
        .tag{font-size:11px;border-radius:999px;border:0;padding:3px 8px;white-space:nowrap;display:inline-flex;align-items:center;gap:4px;font-weight:700;transition:filter .18s}
        .tag:hover{filter:brightness(.97)}
        .tag svg{flex:none;stroke-width:2.1}
        .tag.cattag{background:#e2e8ff;color:#2b44c9}
        .tag.cartag{background:#d7f5ee;color:#0a756f}
        .tag.brandtag{background:#ffe0ee;color:#c01b68}
        .tag.deadlinetag{background:#ffedc9;color:#9a5300}
        .tag.vattag{background:#e9dbff;color:#7226cc}

        .price-area{min-width:0;display:flex;align-items:center;justify-content:space-between;gap:18px;width:100%}
        .price-details{display:flex;flex-direction:column;gap:2px}
        .price{font-size:19px;font-weight:700;letter-spacing:-.4px;white-space:nowrap;color:#141a4a}
        .price small{font-size:11px;color:#6b7497;font-weight:400;letter-spacing:0}
        .price-foot{display:flex;align-items:center;gap:6px;margin-top:2px;min-height:18px;flex-wrap:wrap}
        .old-price{font-size:12px;color:#9aa1bd;text-decoration:line-through;white-space:nowrap}
        .discount-note{font-size:11px;font-weight:700;background:var(--grad-warm);color:#fff;border-radius:999px;padding:1px 8px;display:inline-flex;align-items:center;gap:4px;white-space:nowrap}
        .discount-note svg{flex:none;stroke:#fff}
        .no-discount{height:18px}

        .buy-area{display:flex;flex-direction:column;gap:6px;align-items:flex-start}
        .buy-top{display:flex;align-items:center;gap:9px}
        .qty-wrap{display:flex;align-items:center;gap:6px}
        .qty-control{height:38px;border:0;border-radius:9px;display:flex;align-items:center;overflow:hidden;background:var(--surface-soft);flex:none;transition:background .2s,box-shadow .2s}
        .qty-control button{width:34px;height:34px;border:0;background:transparent;color:var(--blue);font-size:19px}
        .qty-control button:hover{background:var(--blue-soft)}
        .qty-control input{width:38px;text-align:center;border:0;outline:0;font-size:14px;font-weight:700;color:var(--ink);background:transparent}
        .qty-limits-box{display:flex;flex-direction:column;justify-content:center;gap:0;height:38px;min-width:54px;padding:0 5px;border:0;border-radius:9px;background:linear-gradient(180deg,#e4e9fb,#fff3dc);transition:background .2s;flex:none}
        .qty-limits-box .row{display:flex;align-items:center;gap:3px;font-size:10px;line-height:1.1;white-space:nowrap;justify-content:center}
        .qty-limits-box .row + .row{margin-top:2px}
        .qty-limits-box svg{width:12px;height:12px;flex:none}
        .qty-limits-box .num{font-weight:700;font-size:10px;min-width:22px;text-align:center}
        .qty-limits-box .row.max,.qty-limits-box .row.max .num{color:#2b44c9}
        .qty-limits-box .row.min,.qty-limits-box .row.min .num{color:#b36200}
        .qty-limits-box .row.hidden{display:none}
        .qty-wrap.invalid .qty-control{background:#fdeef0;box-shadow:0 0 0 2px rgba(229,56,79,.18)}
        .qty-wrap.invalid .qty-control input,.qty-wrap.invalid .qty-control button{color:var(--red)}
        .qty-wrap.invalid .qty-limits-box{background:#fdeef0}
        .unit-label{font-size:11px;color:#6b7497;font-weight:700;white-space:nowrap;display:inline-flex;align-items:center;justify-content:center;width:36px;flex:none;text-align:center}
        .cart-add{width:38px;height:38px;flex:none;border:0;border-radius:9px;background:var(--grad-main);color:white;display:inline-flex;align-items:center;justify-content:center;padding:0;transition:filter .18s,transform .18s var(--ease)}
        .cart-add svg{flex:none;width:18px;height:18px}
        .cart-add:hover{filter:brightness(1.08);transform:translateY(-1px)}
        .cart-add:disabled{background:#d8dce4}
        .product.in-cart .cart-add{background:var(--grad-green)}
        .product.in-cart .cart-add:hover{background:var(--grad-green)}

        .carton{display:inline-flex;align-items:center;gap:6px;font-size:11px;color:#4f5878;width:auto;max-width:100%;cursor:pointer}
        .carton input{width:17px;height:17px;accent-color:transparent;border:0;border-radius:4px;appearance:none;cursor:pointer;position:relative;flex-shrink:0;background:#dfe5f7}
        .carton input:checked{background:var(--grad-main)}
        .carton input:checked::after{content:"";position:absolute;left:4px;top:1px;width:5px;height:9px;border:solid white;border-width:0 2px 2px 0;transform:rotate(45deg)}
        .carton input:disabled{cursor:not-allowed;opacity:.7}
        .carton.locked{cursor:not-allowed}

        .out-of-stock-area{display:flex;align-items:center;gap:10px}
        .out-of-stock-text{color:var(--red);font-size:13px;font-weight:700}
        .notify-btn{width:38px;height:38px;flex:none;border:0;border-radius:9px;background:var(--grad-red);color:white;display:inline-flex;align-items:center;justify-content:center;transition:filter .2s;padding:0;cursor:pointer}
        .notify-btn:hover{filter:brightness(1.08)}
        .notify-btn svg{flex:none;width:18px;height:18px}

        .pagination{display:flex;justify-content:center;align-items:center;gap:5px;padding:16px 0;flex-wrap:wrap}
        .page-btn{height:36px;min-width:36px;padding:0 10px;border:0;border-radius:9px;background:var(--surface);color:#4a5488;font-size:13px;transition:background .18s,color .18s}
        .page-btn:hover:not(:disabled):not(.active){background:var(--blue-soft);color:var(--blue)}
        .page-btn.active{background:var(--grad-main);color:#fff}
        .page-btn:disabled{opacity:.35;cursor:default}
        .empty{padding:55px 20px;text-align:center;background:var(--surface);border-radius:16px;color:var(--muted)}
        .empty strong{display:block;color:var(--ink);font-size:15px;margin-bottom:5px}
        .footer-note{text-align:center;color:#8f97b5;font-size:11px;padding-top:2px}

        .overlay{position:fixed;inset:0;background:rgba(16,24,40,.4);z-index:90;opacity:0;pointer-events:none;transition:opacity .25s}
        .overlay.show{opacity:1;pointer-events:auto}

        .drawer{position:fixed;z-index:100;left:0;right:0;bottom:0;background:#fff;border-radius:22px 22px 0 0;padding:20px 20px 28px;transform:translateY(105%);transition:transform .3s var(--ease);max-height:85vh;overflow:auto;box-shadow:0 -12px 40px rgba(23,35,58,.15)}
        .drawer.show{transform:translateY(0)}
        .drawer-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:15px;font-weight:700}
        .drawer-close{border:0;background:var(--blue-soft);color:var(--blue);border-radius:9px;width:34px;height:34px;font-size:18px}
        .drawer .filters{grid-template-columns:1fr 1fr}
        .drawer .toggle-field{grid-column:1/-1}
        .drawer .reset{grid-column:1/-1}
        .drawer .sort-field{grid-column:1/-1}
        .drawer .sort-field label{display:block;margin-bottom:6px}

        .side-drawer{position:fixed;z-index:110;top:0;bottom:0;left:0;width:min(420px,92vw);background:#fff;transform:translateX(-105%);transition:transform .3s var(--ease);padding:22px;display:flex;flex-direction:column;box-shadow:15px 0 45px rgba(16,24,40,.15)}
        .side-drawer.show{transform:translateX(0)}
        .side-items{overflow:auto;flex:1}
        .side-item{padding:12px;border:0;border-radius:10px;display:grid;grid-template-columns:1fr auto;gap:6px;background:var(--surface-soft);margin-bottom:6px}
        .side-item strong{font-size:13px}.side-item small{display:block;color:var(--muted);font-size:11px}
        .side-item .remove{border:0;background:transparent;color:var(--red);font-size:12px;font-weight:700}
        .side-total{padding:14px;margin-top:10px;background:var(--surface-soft);border-radius:12px}
        .total-line{display:flex;justify-content:space-between;font-weight:700;font-size:16px}
        .toast{position:fixed;bottom:80px;left:50%;transform:translate(-50%,20px);background:#1b2158;color:white;border-radius:11px;padding:10px 16px;font-size:13px;opacity:0;pointer-events:none;transition:.25s;z-index:200}
        .toast.show{opacity:1;transform:translate(-50%,0)}

        /* نوار پایین موبایل */
        .mobile-bottom-bar{display:none;position:fixed;bottom:0;left:0;right:0;background:rgba(243,245,253,.96);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);z-index:50;padding:6px 8px;padding-bottom:calc(6px + env(safe-area-inset-bottom))}
        .mobile-bottom-bar .bar-inner{display:flex;align-items:center;justify-content:space-around;max-width:600px;margin:0 auto}
        .mobile-bottom-bar button,.mobile-bottom-bar a{display:flex;flex-direction:column;align-items:center;gap:3px;border:0;background:transparent;color:#5b6482;font-size:10px;font-weight:700;padding:3px 10px;border-radius:10px;position:relative;transition:color .2s,background .2s;min-height:44px;text-decoration:none}
        .mobile-bottom-bar button:hover,.mobile-bottom-bar button:active,.mobile-bottom-bar a:hover,.mobile-bottom-bar a:active{color:var(--blue);background:var(--blue-soft)}
        .mobile-bottom-bar svg{width:20px;height:20px;flex:none}
        .mobile-bottom-bar .badge{position:absolute;top:0;right:6px;min-width:16px;height:16px;font-size:9px;border-radius:5px;padding:0 3px;color:#fff;display:inline-flex;align-items:center;justify-content:center;line-height:1}
        .mobile-bottom-bar .cart-count{background:var(--grad-warm)}
        .mobile-bottom-bar .order-count{background:var(--grad-main)}
        .mobile-bottom-bar .active{color:var(--blue)}
        .mobile-bottom-bar .active svg{color:var(--blue)}

        .product-title-row{display:flex;align-items:center;gap:6px;width:100%}
        .product-title-row .product-title{flex:0 1 auto}
        .collapse-btn{width:22px;height:22px;flex:none;border:0;border-radius:6px;background:var(--blue-soft);color:var(--blue);display:inline-flex;align-items:center;justify-content:center;padding:0;cursor:pointer;transition:background .18s,color .18s}
        .collapse-btn:hover{background:var(--blue);color:#fff}
        .collapse-btn svg{transition:transform .25s var(--ease)}
        .collapse-btn.open svg{transform:rotate(180deg)}
        .product-desc{display:none;margin-top:6px;padding-top:6px;font-size:12px;color:#4f5878;line-height:1.65;animation:fadeSlideIn .25s var(--ease)}
        .product-desc.show{display:block}
        @keyframes fadeSlideIn{from{opacity:0;transform:translateY(-4px)}to{opacity:1;transform:translateY(0)}}

        .title-code-inline{display:inline-flex;align-items:center;gap:4px;font-size:10.5px;font-weight:700;color:#3b4aa8;background:var(--blue-soft);border:0;border-radius:999px;padding:2px 8px;white-space:nowrap;flex:none;cursor:pointer;transition:background .18s,color .18s}
        .title-code-inline:hover{background:var(--grad-main);color:#fff}
        .title-code-inline .copy-btn{width:16px;height:16px;background:transparent;color:inherit;pointer-events:none}

        .empty-state{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:14px;padding:24px 0 30px;text-align:center;min-height:260px}
        .empty-state-message{font-size:14px;font-weight:700;color:#141a4a;line-height:1.8;max-width:480px;order:1}
        .empty-state-message span{display:block;font-size:11px;font-weight:400;color:var(--muted);margin-top:6px}
        .empty-car-image{order:0;width:100%;max-width:220px;display:flex;justify-content:center;align-items:center;padding:0 12px}
        .empty-car-image img{width:100%;max-width:180px;height:auto;display:block;border-radius:12px}
        .empty-slider{order:2;width:100%;max-width:900px;position:relative;border-radius:16px;overflow:hidden;background:#eef1f6}
        .slider-track{position:relative;width:100%;aspect-ratio:32/9}
        .slider-slide{position:absolute;inset:0;opacity:0;transition:opacity .6s var(--ease);pointer-events:none}
        .slider-slide.active{opacity:1;pointer-events:auto}
        .slider-slide img{width:100%;height:100%;object-fit:cover;display:block}
        .slider-arrow{position:absolute;top:50%;transform:translateY(-50%);width:34px;height:34px;border:0;border-radius:50%;background:rgba(255,255,255,.9);color:var(--blue);display:inline-flex;align-items:center;justify-content:center;cursor:pointer;z-index:3;transition:background .2s,transform .2s;padding:0}
        .slider-arrow:hover{background:#fff;transform:translateY(-50%) scale(1.06)}
        .slider-arrow.prev{right:8px}.slider-arrow.next{left:8px}
        .slider-arrow svg{width:16px;height:16px}
        .slider-dots{position:absolute;bottom:10px;left:50%;transform:translateX(-50%);display:flex;gap:7px;z-index:3}
        .slider-dot{width:7px;height:7px;border-radius:50%;border:0;background:rgba(255,255,255,.55);cursor:pointer;padding:0;transition:background .2s,transform .2s}
        .slider-dot.active{background:#fff;transform:scale(1.25)}

        /* ---------- دکمه فیلتر موبایل (در هدر) با گرادیان قرمز-نارنجی ---------- */
        .mobile-filter{
            display:none;
            position:relative;
            flex:none;
            width:44px;height:44px;border:0;border-radius:11px;
            background:var(--grad-warm);color:#fff;
            align-items:center;justify-content:center;
            padding:0;
            box-shadow:0 6px 14px rgba(255,93,115,.30);
            transition:filter .18s, transform .18s var(--ease);
        }
        .mobile-filter:hover{filter:brightness(1.08);transform:translateY(-1px)}
        .mobile-filter svg{width:20px;height:20px;flex:none}
        .mobile-filter .filter-count{
            position:absolute;top:-6px;left:-6px;
            min-width:18px;height:18px;font-size:10px;font-weight:700;
            padding:0 4px;border-radius:6px;background:#fff;color:#e5384f;
            display:none;align-items:center;justify-content:center;
            box-shadow:0 0 0 2px rgba(229,56,79,.2);
            line-height:1;
        }

        /* ---------- دکمه سبد خرید موبایل (کنار فیلتر، در هدر) ---------- */
        .mobile-cart{
            display:none;
            position:relative;
            flex:none;
            width:44px;height:44px;border:0;border-radius:11px;
            background:var(--surface-soft);color:#3a4580;
            align-items:center;justify-content:center;
            padding:0;
            transition:filter .18s, transform .18s var(--ease), background .18s;
        }
        .mobile-cart:hover{background:var(--blue-soft);color:var(--blue)}
        .mobile-cart svg{width:20px;height:20px;flex:none}
        .mobile-cart .cart-count{
            position:absolute;top:-6px;left:-6px;
            min-width:18px;height:18px;font-size:10px;font-weight:700;
            padding:0 4px;border-radius:6px;background:var(--grad-warm);color:#fff;
            display:inline-flex;align-items:center;justify-content:center;
            line-height:1;
        }

        /* ---------- توتریال دکمه فیلتر ---------- */
        .filter-tutorial{
            position:absolute;
            top:calc(100% + 10px);
            left:50%;transform:translateX(-50%);
            background:linear-gradient(135deg,#e5384f 0%,#ff9248 100%);
            color:#fff;
            font-size:11px;font-weight:700;
            padding:7px 12px;
            border-radius:10px;
            white-space:nowrap;
            z-index:200;
            box-shadow:0 8px 20px rgba(229,56,79,.35);
            opacity:0;pointer-events:none;
            transition:opacity .3s, transform .3s;
        }
        .filter-tutorial::before{
            content:'';position:absolute;
            bottom:100%;left:50%;transform:translateX(-50%);
            border:6px solid transparent;border-bottom-color:#e5384f;
        }
        .filter-tutorial.show{opacity:1;transform:translateX(-50%) translateY(0);animation:tutPulse 1.2s ease-in-out infinite}
        @keyframes tutPulse{
            0%,100%{box-shadow:0 8px 20px rgba(229,56,79,.35)}
            50%{box-shadow:0 8px 26px rgba(255,146,72,.55)}
        }
        .filter-tutorial .tut-arrow{display:inline-block;margin-left:4px;animation:tutUp 1s ease-in-out infinite}
        @keyframes tutUp{
            0%,100%{transform:translateY(0)}
            50%{transform:translateY(-3px)}
        }

        @media(max-width:760px){
            .app{padding:10px 10px 88px}
            .toolbar-wrap{padding:10px 0 8px;margin:0 -6px 8px}
            .toolbar-wrap.stuck{background:rgba(233,237,251,.92)}
            .toolbar{padding:10px;border-radius:13px;position:relative}
            .filters{grid-template-columns:1fr 1fr;gap:8px}
            .searchline{margin-bottom:0;flex-wrap:nowrap;gap:7px}
            .desktop-filters{display:none}
            .quick-actions{display:none}
            .logo-btn{order:0;display:inline-flex;flex:none;width:36px;height:36px}
            .searchbox{order:1;flex:1;min-width:0}
            .searchbox input{height:44px;font-size:14px;padding-right:38px}
            .mobile-filter{order:2;display:inline-flex}
            .mobile-cart{order:3;display:inline-flex}
            .mobile-bottom-bar{display:block}
            .list-head{padding:8px 3px 7px;font-size:12px}
            .footer-note{padding-bottom:6px;font-size:10px}
            .toast{bottom:78px;font-size:12px;padding:9px 14px}
            .product{display:flex;flex-direction:column;gap:10px;padding:12px;border-radius:14px;align-items:stretch}
            .product-main{display:flex;flex-direction:column;gap:4px;width:100%}
            .title-row{display:flex;align-items:center;gap:8px;width:100%}
            .product-title{font-size:14px;font-weight:700;line-height:1.45;color:var(--ink);flex:1}
            .collapse-btn{width:20px;height:20px}
            .product-desc{font-size:11.5px;margin-top:6px;padding-top:6px;line-height:1.6}
            .tags{display:flex;flex-wrap:wrap;gap:5px;margin-top:3px;width:100%}
            .tag{font-size:10px;padding:3px 7px;border-radius:6px}
            .title-code-inline{font-size:10px;padding:1px 6px}
            .price-area{display:flex;flex-direction:row;align-items:flex-end;justify-content:space-between;width:100%;margin-top:4px;padding-top:4px}
            .price-details{display:flex;flex-direction:column;gap:2px;text-align:right}
            .price{font-size:16px;font-weight:700}
            .price small{font-size:10px}
            .price-foot{display:flex;align-items:center;gap:5px;min-height:auto}
            .old-price{font-size:10px}
            .discount-note{font-size:9px;padding:1px 6px}
            .buy-area{display:flex;flex-direction:column;align-items:flex-start;gap:6px;width:auto;margin:0}
            .buy-top{display:flex;align-items:center;gap:7px}
            .qty-control{height:34px}
            .qty-control button{width:28px;height:31px;font-size:16px}
            .qty-control input{width:30px;font-size:13px}
            .qty-limits-box{height:34px;min-width:44px;padding:0 3px}
            .qty-limits-box .row{font-size:9px}
            .qty-limits-box .num{font-size:9px;min-width:18px}
            .qty-limits-box svg{width:10px;height:10px}
            .unit-label{display:inline-block;width:28px;font-size:10px}
            .cart-add{width:34px;height:34px;border-radius:8px}
            .cart-add svg{width:16px;height:16px}
            .carton{width:auto;justify-content:flex-start;font-size:10px;margin-top:0;padding:0;background:transparent;border-radius:0;gap:5px}
            .carton input{width:15px;height:15px}
            .out-of-stock-area{display:flex;flex-direction:row;align-items:center;gap:12px}
            .out-of-stock-text{font-size:12px}
            .notify-btn{width:34px;height:34px;border-radius:8px}
            .notify-btn svg{width:16px;height:16px}
            .pagination{gap:4px;padding:14px 0}
            .page-btn{height:34px;min-width:34px;font-size:12px}
            .empty-state{padding:24px 0 30px;gap:14px;min-height:260px}
            .empty-slider{max-width:100%}
            .slider-arrow{width:30px;height:30px}
            .slider-arrow.prev{right:6px}.slider-arrow.next{left:6px}

            .profile-menu{position:fixed;top:auto;bottom:0;left:0;right:0;min-width:0;border-radius:18px 18px 0 0;box-shadow:0 -12px 40px rgba(23,35,58,.18);transform:translateY(105%);max-height:80vh;overflow:auto;z-index:150}
            .profile-menu.show{display:block;transform:translateY(0)}
            .profile-menu-head{border-radius:18px 18px 0 0}
        }
        @media(max-width:380px){.drawer .filters{grid-template-columns:1fr}.drawer .toggle-field,.drawer .reset,.drawer .sort-field{grid-column:auto}}

        @media(max-width:760px){
            .drawer .custom-select{position:static}
            .custom-options.drawer-sheet{
                position:fixed;top:auto;bottom:0;left:0;right:0;
                max-height:70vh;
                border-radius:18px 18px 0 0;z-index:400;
                display:flex;flex-direction:column;overflow:hidden;
                box-shadow:0 -12px 40px rgba(23,35,58,.18);
                background:#fff;
            }
            .custom-options.drawer-sheet .custom-options-search{
                display:block;flex:0 0 auto;padding:12px 12px 10px;
                background:var(--surface-soft);border-radius:18px 18px 0 0;
                box-shadow:0 1px 0 rgba(23,35,58,.06);
            }
            .custom-options.drawer-sheet .custom-options-search input{
                display:block;width:100%;height:46px;font-size:15px;
                border:0;border-radius:10px;background:#fff;padding:0 12px;outline:none;
            }
            .custom-options.drawer-sheet .custom-options-search input:focus{box-shadow:0 0 0 2px rgba(67,97,238,.25)}
            .custom-options.drawer-sheet .custom-options-list{
                flex:1 1 auto;overflow-y:auto;padding:6px 8px 10px;background:#fff;
                -webkit-overflow-scrolling:touch;
            }
            .custom-options.drawer-sheet .custom-option{padding:14px 16px;font-size:15px}
            .custom-options.drawer-sheet::before{
                content:'';position:fixed;inset:0;background:rgba(16,24,40,.4);z-index:-1;
            }
        }

        @media(min-width:761px){
            .desktop-filters .filters{grid-template-columns:1fr 1fr 1fr 1.1fr auto auto;align-items:end}
            .desktop-filters .field label{display:none}
            .desktop-filters .sort-select-wrapper .custom-select-trigger{position:static}
        }
    </style>
</head>
<body>
<form action="http://radmanpakhsh/Framework/Services/AuthenticationService.svc/login" method="post">
    @csrf
    <input type="text" name="sessionId">
    <input type="text" name="username">
    <input type="text" name="password">
    <input type="submit" value="ارسال">
</form>
</body>
</html>
