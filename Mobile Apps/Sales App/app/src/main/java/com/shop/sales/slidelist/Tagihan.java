package com.shop.sales.slidelist;

import android.app.Activity;
import android.app.Fragment;
import android.app.ProgressDialog;
import android.app.AlertDialog;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.os.SystemClock;
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
import android.view.WindowManager;
import android.location.Location;
import android.location.LocationManager;
import android.location.LocationListener;
import android.location.Geocoder;
import android.location.Address;
import android.net.Uri;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.content.DialogInterface;
import android.content.ContentResolver;
import android.widget.Toast;
import android.graphics.Bitmap;
import java.util.List;
import java.util.Locale;
import java.io.IOException;
import android.provider.Settings;

import com.shop.sales.DetectConnection;
import com.shop.sales.App;
import com.shop.sales.R;

public class Tagihan extends Fragment
{
	private WebView myView;
	private String mUrl, mWeb, barcode2;
	private String gps, city, tipe, akurasi, mock;
	private boolean eror, timeout, handle;
	private ProgressDialog dialog, dialog2;
	private static Handler myHandler;
	private static Runnable run,run2;
	private LocationManager locationManager;
	private LocationListener locationListener;
	
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
							 Bundle savedInstanceState) {
		View rootView = inflater
			.inflate(R.layout.main, container, false);
		
		mUrl = App.getHOST();
		mWeb = App.getWeb() + "/?page=collector&mode=tagihan";
		orientation(0);
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
		run2 = new Runnable() {
			public void run() {
				if(checkGPS()) {
					if (dialog2 !=null && dialog2.isShowing()) dialog2.setMessage("Silahkan Menunggu.");
					myHandler = new Handler(Looper.myLooper());
					myHandler.postDelayed(run2, 1000);
				} else {
					if (dialog2 !=null && dialog2.isShowing()) dialog2.setMessage("Silahkan Mengaktifkan GPS.");
					myHandler = new Handler(Looper.myLooper());
					myHandler.postDelayed(run2, 1000);
				}
			}
		};
		
		myView.loadUrl(mWeb);
		return rootView;
    }
	
	@Override
	public void onDestroy(){
		quit_handler();
		if(locationListener!=null)
		locationManager.removeUpdates(locationListener);
		super.onDestroy();
	}
	
	public void quit_handler(){
		if (myHandler != null) {
			myHandler.removeCallbacks(run);
			myHandler.removeCallbacks(run2);
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
		Intent intent = new Intent("com.google.zxing.client.android.SCAN2");
		intent.putExtra("PROMPT_MESSAGE","Silahkan Scan Barcode " + tipe_scan + ".");
		startActivityForResult(intent, 0);
	}
	
	public void getLocation(){
		if (dialog2 !=null && dialog2.isShowing()) dialog2.dismiss();
		dialog2 = ProgressDialog.show(getActivity(),null,"Silahkan menunggu.",true);
		quit_handler();
		myHandler = new Handler(Looper.myLooper());
		myHandler.postDelayed(run2, 1000);
		locationManager = (LocationManager)
			getActivity().getSystemService(getActivity().LOCATION_SERVICE);
		locationListener = new MyLocationListener();
	//	if (checkGPS()){
			Location loc = locationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
			long beda = ((SystemClock.elapsedRealtimeNanos() - loc.getElapsedRealtimeNanos()) / 1000000)/(60*1000);
			if (loc==null || beda>10){
				locationManager.requestLocationUpdates(
					LocationManager.GPS_PROVIDER, 500, 50, locationListener);
			} else {
				setLocation(loc);
			}
	/*	} else {
			locationManager.requestLocationUpdates(
				LocationManager.GPS_PROVIDER, 0, 0, locationListener);
		}*/
	}
	
	public void setLocation(Location loc){
		String longitude = "Longitude: " + loc.getLongitude();
		String latitude = "Latitude: " + loc.getLatitude();

		/*------- To get city name from coordinates -------- */
		String cityName = null;
		Geocoder gcd = new Geocoder(getActivity(), Locale.getDefault());
		List<Address> addresses;
		try {
			addresses = gcd.getFromLocation(loc.getLatitude(),
											loc.getLongitude(), 1);
			if (addresses.size() > 0) {
				System.out.println(addresses.get(0).getLocality());
				cityName = addresses.get(0).getLocality();
			}
		}
		catch (IOException e) {
			e.printStackTrace();
		}
		mock="0";
		if (isMockLocation(loc)){
			//			myView.evaluateJavascript("get_lokasi('Lokasi tidak ditemukan');", null);
			//			return;
			mock="1";
		}
		gps = longitude + "," + latitude;
		city = cityName;
		akurasi = String.valueOf(loc.getAccuracy());

		if (loc.getAccuracy()<=50){
			myView.post(new Runnable() {
					@Override
					public void run() {
						if (myHandler != null) locationManager.removeUpdates(locationListener);
						myHandler.removeCallbacks(run2);
						getActivity().getWindow().clearFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);
						myView.evaluateJavascript("set_lokasi('" + gps + "','" + city + "','" + akurasi + "','" + mock + "');", null);
						if (dialog2 !=null && dialog2.isShowing()) dialog2.dismiss();
					}
				});
		}
	}
	
	public boolean checkGPS(){
		ContentResolver cr = getActivity().getBaseContext().getContentResolver();
		boolean gpsStatus = Settings.Secure.isLocationProviderEnabled(cr, locationManager.GPS_PROVIDER);
		return gpsStatus;
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
				public void getLokasi() throws Exception
				{
					getLocation();
					myView.post(new Runnable() {
						@Override
						public void run() {
							getActivity().getWindow().addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);
						}
					});
				}
				@JavascriptInterface
				public void compare(String lat, String lng, String curLat, String curLng) throws Exception
				{
					compare_location(lat, lng, curLat, curLng);
				}
				@JavascriptInterface
				public void setOrientasi(int orientasi) throws Exception
				{
					orientation(orientasi);
				}
				@JavascriptInterface
				public void removeLokasi() throws Exception
				{
					if(locationListener!=null)
						locationManager.removeUpdates(locationListener);
				}
				@JavascriptInterface
				public void scanToko()
				{
					tipe="scan_toko";
					scan_barcode("Toko");
				}
				@JavascriptInterface
				public void scanNota()
				{
					tipe="scan_nota";
					scan_barcode("Nota");
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
				if (tipe.equals("scan_toko")){
					myView.evaluateJavascript("get_toko('" + barcode2 + "');", null);
				} else if (tipe.equals("scan_nota")){
					myView.evaluateJavascript("cek_scan_nota('" + barcode2 + "');", null);
				}
			} else if (resultCode == Activity.RESULT_CANCELED) {
				// Handle cancel
				myView.evaluateJavascript("batal_scan();", null);
			}
		}
	}
	
	private class MyLocationListener implements LocationListener {
		@Override
		public void onLocationChanged(Location loc) {
			setLocation(loc);
		}
		
		@Override
		public void onProviderDisabled(String provider) {}

		@Override
		public void onProviderEnabled(String provider) {}

		@Override
		public void onStatusChanged(String provider, int status, Bundle extras) {}
		
	}
	
	private void compare_location(String lat_, String lng_, String curLat_, String curLng_){
		final float[] distance = new float[1];
		Location.distanceBetween(Double.parseDouble(lat_), Double.parseDouble(lng_), Double.parseDouble(curLat_), Double.parseDouble(curLng_), distance);
		if (distance[0] < 50.0){
	//		createDialog(String.valueOf(distance[0]));
		}
		myView.post(new Runnable() {
			@Override
			public void run() {
				myView.evaluateJavascript("setDistance('" + String.valueOf(distance[0]) + "');", null);
			}
		});
	//	createDialog("Beda jarak : " + String.valueOf(distance[0]) + " m");
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
	private boolean isMockLocation(Location loc){
		boolean isMock = false;
		if (android.os.Build.VERSION.SDK_INT >= 18) {
			isMock = loc.isFromMockProvider();
		} else {
			isMock = !Settings.Secure.getString(getActivity().getContentResolver(), Settings.Secure.ALLOW_MOCK_LOCATION).equals("0");
		}
		return isMock;
	}
	
}
