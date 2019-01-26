package com.shop.gudang;

import android.net.Uri;
import android.graphics.Bitmap;

import android.annotation.SuppressLint;
import android.view.View;
import android.view.WindowManager;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.app.Activity;
import android.app.ProgressDialog;
import android.app.AlertDialog;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.webkit.WebResourceRequest;
import android.webkit.WebResourceError;
import android.content.Intent;
import android.content.DialogInterface;
import android.content.pm.ActivityInfo;

public class SplashActivity extends Activity {
	
	private WebView myView;
	private ProgressDialog dialog;
	private static Handler myHandler;
	private static Runnable run;
	private boolean eror, timeout, handle;
	private String mUrl, mWeb;
	

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		orientation(1);
		super.onCreate(savedInstanceState);
     	setContentView(R.layout.splash);
		mUrl=App.getHOST();
		mWeb=App.getWeb() + "/load_cache.php";
		
		myView = (WebView) findViewById(R.id.webView);
		myView.setVisibility(View.GONE);
		myView.getSettings().setJavaScriptEnabled(true);
		myView.setScrollBarStyle(View.SCROLLBARS_OUTSIDE_OVERLAY);
		myView.setWebViewClient(new MyBrowser());
		myView.getSettings().setSaveFormData(false);
		myView.clearFormData();
		myView.setFocusableInTouchMode(true);
		myView.requestFocus();
		
		run = new Runnable() {
			public void run() {
				if(timeout) {
					handle=true;
					myView.stopLoading();
					if (SplashActivity.this !=null){
						createDialog("Connection Timed out");
					}
				} else {
					handle=false;
				}
			}
		};
		
		Handler myHandler2 = new Handler(Looper.myLooper());
		myHandler2.postDelayed(new Runnable() {
				public void run() {
					getWindow().addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);
					myView.loadUrl(mWeb);
				}
		}, 50);
	}
	private void orientation(int orientation){
		switch(orientation){
			case 0:
				this.setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);
				break;
			case 1:
				this.setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
				break;
		}
	}
	public void quit_handler(){
		if (myHandler != null) {
			myHandler.removeCallbacks(run);
		}
	}
	
	private class MyBrowser extends WebViewClient {
		@Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
			if(Uri.parse(url).getHost().endsWith(mUrl)){
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
			myHandler.postDelayed(run, 60000);
			if (dialog !=null && dialog.isShowing()) dialog.dismiss();
			dialog = ProgressDialog.show(SplashActivity.this,null,"Sedang memuat cache.",true);
			super.onPageStarted(view, url, favicon);
		}
		@Override
        public void onPageFinished(WebView view, String url){
			if (!handle) timeout=false;
			if (!handle) eror = false;
			if (dialog !=null && dialog.isShowing()) dialog.dismiss();
			myView.post(new Runnable() {
				@Override
				public void run() {
					getWindow().clearFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);
				}
			});
			startActivity(new Intent(SplashActivity.this,MainActivity.class));
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
	private void createDialog(String pesan){
		AlertDialog.Builder builder = new AlertDialog.Builder(SplashActivity.this);
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
}
