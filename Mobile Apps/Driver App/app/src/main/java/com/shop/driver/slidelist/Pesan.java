package com.shop.driver.slidelist;

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
import android.net.Uri;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.content.DialogInterface;
import android.widget.Toast;
import android.graphics.Bitmap;

import com.shop.driver.DetectConnection;
import com.shop.driver.App;
import com.shop.driver.R;

public class Pesan extends Fragment
{
	private WebView myView;
	private String mUrl, mWeb;
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
		mWeb = App.getWeb() + "/?page=pesan&mode=pesan";
		
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
		quit_handler();
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
				public void showToast(String pesan) throws Exception
				{
					createDialog(pesan);
				}
				@JavascriptInterface
				public void closeApp() throws Exception
				{
					getActivity().onBackPressed();
				}
				@JavascriptInterface
				public void setOrientasi(int orientasi) throws Exception
				{
					orientation(orientasi);
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
	
	private void createDialog(String pesan){
		AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
		builder.setTitle("Sales App")
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
