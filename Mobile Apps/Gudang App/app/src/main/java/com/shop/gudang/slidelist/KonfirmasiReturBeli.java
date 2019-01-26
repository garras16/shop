package com.shop.gudang.slidelist;

import android.app.Activity;
import android.app.Fragment;
import android.app.ProgressDialog;
import android.app.AlertDialog;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.webkit.JavascriptInterface;
import android.webkit.WebResourceRequest;
import android.webkit.WebResourceResponse;
import android.webkit.WebResourceError;
import android.view.View;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.ViewGroup;
import android.view.MotionEvent;
import android.net.Uri;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.content.DialogInterface;
import android.widget.Toast;
import android.graphics.Bitmap;

import com.shop.gudang.DetectConnection;
import com.shop.gudang.App;
import com.shop.gudang.R;

public class KonfirmasiReturBeli extends Fragment
{
	private WebView myView;
	private String mUrl, mWeb, barcode1, barcode2;
	private String id_retur_beli_detail, tipe;
	private boolean eror, timeout, handle;
	private ProgressDialog dialog;
	private static Handler myHandler;
	private static Runnable run;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
							 Bundle savedInstanceState) {
		orientation(1);
		View rootView = inflater
			.inflate(R.layout.main, container, false);
		
		mUrl = App.getHOST();
		//mUrl = "silsoft-test.000webhostapp.com";
		//mUrl = "silsoft.id";
		//mWeb = "http://" + mUrl + "/shop/?page=gudang&mode=konfirm_retur_beli";
		//mWeb = "http://" + mUrl + "/mobile/?page=gudang&mode=konfirm_retur_beli";
		mWeb = App.getWeb() + "/?page=gudang&mode=konfirm_retur_beli";
		myView = (WebView) rootView.findViewById(R.id.webView);
		myView.getSettings().setJavaScriptEnabled(true);
		myView.getSettings().setDomStorageEnabled(true);
		myView.getSettings().setAllowFileAccessFromFileURLs(true);
		myView.getSettings().setAllowUniversalAccessFromFileURLs(true);
		myView.setScrollBarStyle(View.SCROLLBARS_OUTSIDE_OVERLAY);
		myView.setWebViewClient(new MyBrowser());
		myView.getSettings().setSaveFormData(false);
		myView.clearFormData();
		myView.setFocusableInTouchMode(true);
		myView.requestFocus();
		myView.setOnKeyListener(new View.OnKeyListener() {
			@Override
			public boolean onKey(View v, int keyCode, KeyEvent event) {
				if (event.getAction()!=KeyEvent.ACTION_DOWN)
                    return true;
				if (keyCode == KeyEvent.KEYCODE_BACK) {
					if (eror || timeout){
						getActivity().onBackPressed();
					} else {
						myView.evaluateJavascript("getBack()", null);
					}
					return true;
				}
				return false;
			}
		});
		run = new Runnable() {
			public void run() {
				if(timeout) {
					handle=true;
					if (getActivity()!=null){
						
					}
				} else {
					handle=false;
				}
			}
		};
	
		myView.loadUrl(mWeb);
		return rootView;
    }
	
	@Override
	public void onDestroy(){
		quit_handler();/*
		myView.removeJavascriptInterface("scan");
		myView.removeJavascriptInterface("scan_rak");*/
		//myView.removeJavascriptInterface("AndroidFunction");
		super.onDestroy();
	}
	
	public void quit_handler(){
		if (myHandler != null) {
			myHandler.removeCallbacks(run);
		}
	}
	
	private void orientation(int orientation){
		switch(orientation){
			case 0:
				getActivity().setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);
				break;
			case 1:
				getActivity().setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
				break;
		}
	}
	
	private void scan_barcode(String tipe_scan){
		Intent intent = new Intent("com.google.zxing.client.android.SCAN1");
		intent.putExtra("PROMPT_MESSAGE","Silahkan Scan Barcode " + tipe_scan + ".");
		startActivityForResult(intent, 0);
	}
	
	private class MyBrowser extends WebViewClient {
		@Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
			if(Uri.parse(url).getHost().endsWith(mUrl)) {
				return false;
            }
			
			Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(url));
			view.getContext().startActivity(intent);
            return true;
        }
		@Override
		public void onPageStarted(WebView view, String url, Bitmap favicon) {
			quit_handler();
			timeout=true;
			
			myHandler = new Handler(Looper.myLooper());
			myHandler.postDelayed(run, 10000);
			if (dialog !=null && dialog.isShowing()) dialog.dismiss();
			dialog = ProgressDialog.show(getActivity(),null,"Silahkan menunggu.",true);
			super.onPageStarted(view, url, favicon);
		}
		@Override
        public void onPageFinished(WebView view, String url){
			if (!handle) timeout=false;
			if (!handle) eror = false;
			if (dialog !=null && dialog.isShowing()) dialog.dismiss();
			view.addJavascriptInterface(new Object()
			{
				@JavascriptInterface
				public void scan_barang(String barcode, String id) throws Exception
				{
					tipe="scan_barang";
					barcode1=barcode; id_retur_beli_detail=id;
					scan_barcode("Barang");
				}
				@JavascriptInterface
				public void scan_rak(String barcode) throws Exception
				{
					tipe="scan_rak";
					barcode1=barcode;
					scan_barcode("Rak");
				}
				@JavascriptInterface
				public void showToast(String pesan) throws Exception
				{
					createDialog(pesan);
				}
				@JavascriptInterface
				public void closeApp() throws Exception
				{
					getActivity().onBackPressed();
				}
			}, "AndroidFunction");

		}
		
		@Override
		public void onReceivedError(WebView view, WebResourceRequest request, WebResourceError error) {
			if (error.getErrorCode()!=-15){
				view.loadUrl("file:///android_asset/error.html");
				eror = true;
			}
			super.onReceivedError(view, request, error);
		}
	}
	
	public void onActivityResult(int requestCode, int resultCode, Intent intent) {
		if (requestCode == 0) {
			if (resultCode == Activity.RESULT_OK) {
				barcode2 = intent.getStringExtra("SCAN_RESULT");
				if (tipe.equals("scan_barang")){
					myView.evaluateJavascript("barcode('" + barcode1 + "','" + barcode2 + "'," + id_retur_beli_detail + ");", null);
				} else if (tipe.equals("scan_rak")){
					myView.evaluateJavascript("barcode('" + barcode1 + "','" + barcode2 + "');", null);
				}
			} else if (resultCode == Activity.RESULT_CANCELED) {
				// Handle cancel
			}
		}
	}
	
	private void createDialog(String pesan){
		AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
		builder.setTitle("Gudang App")
		    .setIcon(R.drawable.ic_launcher)
		    .setMessage(pesan)
		    .setCancelable(false)
		    .setPositiveButton(
			"OK",
			new DialogInterface.OnClickListener() {
				public void onClick(DialogInterface dialog, int id) {
					dialog.cancel();
				}
			});
		AlertDialog alert1 = builder.create();
		alert1.show();
	}
	private void alert(String pesan){
		Toast.makeText(getActivity(), pesan, Toast.LENGTH_SHORT).show();
	}
	
}
