package com.shop.driver.slidelist;

import android.app.Activity;
import android.app.Fragment;
import android.app.ProgressDialog;
import android.app.AlertDialog;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.os.Environment;
import android.os.SystemClock;
import android.os.AsyncTask;
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
import android.graphics.BitmapFactory;
import android.provider.Settings;
import android.provider.MediaStore;
import android.util.Base64;

import java.util.List;
import java.util.Locale;
import java.util.HashMap;
import java.util.Map;
import java.io.IOException;
import java.io.File;
import java.io.ByteArrayOutputStream;
import java.io.OutputStream;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.OutputStreamWriter;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.URL;
import java.net.HttpURLConnection;
import java.net.URLEncoder;
import javax.net.ssl.HttpsURLConnection;

import com.shop.driver.DetectConnection;
import com.shop.driver.App;
import com.shop.driver.R;


public class Keluar extends Fragment
{
	private WebView myView;
	private String mUrl, mWeb, barcode2;
	private String gps, city, tipe, akurasi, mock;
	private boolean eror, timeout, handle;
	private ProgressDialog dialog, dialog2;
	private static Handler myHandler;
	private static Runnable run,run2;
	private static final int CAMERA_REQUEST = 1888;
	private LocationManager locationManager;
	private LocationListener locationListener;
	
	
    Bitmap bitmap;
    boolean check = true;
    String GetImageNameFromEditText;
    String ImageNameFieldOnServer = "image_name";
    String ImagePathFieldOnServer = "image_path";
    String ImageUploadPathOnSever = App.getWeb() + "/../capture_img_upload_to_server.php";
	String mCurrentPhotoPath;
	Uri photoURI;
	
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
							 Bundle savedInstanceState) {
		orientation(1);
		View rootView = inflater
			.inflate(R.layout.main, container, false);
		
		mUrl = App.getHOST();
		mWeb = App.getWeb() + "/?page=driver&mode=barang_keluar";
		
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
		Intent intent = new Intent("com.google.zxing.client.android.SCAN3");
		intent.putExtra("PROMPT_MESSAGE","Silahkan Scan Barcode " + tipe_scan + ".");
		startActivityForResult(intent, 0);
	}
	
	private void getCamera(){
		Intent cameraIntent = new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
		String filename = Environment.getExternalStorageDirectory().getPath() + "/test.jpg";
        photoURI = Uri.fromFile(new File(filename));
        cameraIntent.putExtra(MediaStore.EXTRA_OUTPUT, photoURI);
        startActivityForResult(cameraIntent, CAMERA_REQUEST);
	}
	
	public boolean checkGPS(){
		ContentResolver cr = getActivity().getBaseContext().getContentResolver();
		boolean gpsStatus = Settings.Secure.isLocationProviderEnabled(cr, locationManager.GPS_PROVIDER);
		return gpsStatus;
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
					if (myHandler != null) myHandler.removeCallbacks(run2);
					locationManager.removeUpdates(locationListener);
					getActivity().getWindow().clearFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);
					myView.evaluateJavascript("set_lokasi('" + gps + "','" + city + "','" + akurasi + "','" + mock + "');", null);
					if (dialog2 !=null && dialog2.isShowing()) dialog2.dismiss();
				}
			});
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
				public void getFoto(String id_poto)
				{
					tipe="get_foto";
					GetImageNameFromEditText=id_poto + ".jpg";
					getCamera();
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
					myView.evaluateJavascript("cek_scan_toko('" + barcode2 + "');", null);
				}
			} else if (resultCode == Activity.RESULT_CANCELED) {
				// Handle cancel
				myView.evaluateJavascript("batal_scan();", null);
			}
		} else if (requestCode == CAMERA_REQUEST && resultCode == Activity.RESULT_OK) {
			bitmap = BitmapFactory.decodeFile(photoURI.getPath());
			new File(photoURI.getPath()).delete();
			if (bitmap.getWidth()>bitmap.getHeight()){
				bitmap = Bitmap.createScaledBitmap(bitmap, 640, 480, false);
			} else {
				bitmap = Bitmap.createScaledBitmap(bitmap, 480, 640, false);
			}
			ImageUploadToServerFunction();
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
	
	public void compare_location(String lat_, String lng_, String curLat_, String curLng_){
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
		builder.setTitle("Driver App")
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
	
	public void ImageUploadToServerFunction(){
        ByteArrayOutputStream byteArrayOutputStreamObject ;
        byteArrayOutputStreamObject = new ByteArrayOutputStream();
		bitmap.compress(Bitmap.CompressFormat.JPEG, 100, byteArrayOutputStreamObject);
        byte[] byteArrayVar = byteArrayOutputStreamObject.toByteArray();
        final String ConvertImage = Base64.encodeToString(byteArrayVar, Base64.DEFAULT);
        class AsyncTaskUploadClass extends AsyncTask<Void,Void,String> {

            @Override
            protected void onPreExecute() {
                super.onPreExecute();
                dialog = ProgressDialog.show(getActivity(),"Image is Uploading","Please Wait",false,false);
            }

            @Override
            protected void onPostExecute(String string1) {
                super.onPostExecute(string1);
				myView.evaluateJavascript("updateFoto();", null);
                dialog.dismiss();
                Toast.makeText(getActivity(),string1,Toast.LENGTH_LONG).show();
            }

            @Override
            protected String doInBackground(Void... params) {
                ImageProcessClass imageProcessClass = new ImageProcessClass();
                HashMap<String,String> HashMapParams = new HashMap<String,String>();
                HashMapParams.put(ImageNameFieldOnServer, GetImageNameFromEditText);
                HashMapParams.put(ImagePathFieldOnServer, ConvertImage);
                String FinalData = imageProcessClass.ImageHttpRequest(ImageUploadPathOnSever, HashMapParams);
                return FinalData;
            }
        }
        AsyncTaskUploadClass AsyncTaskUploadClassOBJ = new AsyncTaskUploadClass();
        AsyncTaskUploadClassOBJ.execute();
    }

    public class ImageProcessClass{
        public String ImageHttpRequest(String requestURL,HashMap<String, String> PData) {
            StringBuilder stringBuilder = new StringBuilder();
            try {
                URL url;
                HttpURLConnection httpURLConnectionObject ;
                OutputStream OutPutStream;
                BufferedWriter bufferedWriterObject ;
                BufferedReader bufferedReaderObject ;
                int RC ;
                url = new URL(requestURL);
                httpURLConnectionObject = (HttpURLConnection) url.openConnection();
                httpURLConnectionObject.setReadTimeout(19000);
                httpURLConnectionObject.setConnectTimeout(19000);
                httpURLConnectionObject.setRequestMethod("POST");
                httpURLConnectionObject.setDoInput(true);
                httpURLConnectionObject.setDoOutput(true);
                OutPutStream = httpURLConnectionObject.getOutputStream();
                bufferedWriterObject = new BufferedWriter(
					new OutputStreamWriter(OutPutStream, "UTF-8"));
                bufferedWriterObject.write(bufferedWriterDataFN(PData));
                bufferedWriterObject.flush();
                bufferedWriterObject.close();
                OutPutStream.close();
                RC = httpURLConnectionObject.getResponseCode();
                if (RC == HttpsURLConnection.HTTP_OK) {
                    bufferedReaderObject = new BufferedReader(new InputStreamReader(httpURLConnectionObject.getInputStream()));
                    stringBuilder = new StringBuilder();
                    String RC2;
                    while ((RC2 = bufferedReaderObject.readLine()) != null){
                        stringBuilder.append(RC2);
                    }
                }
            } catch (Exception e) {
                e.printStackTrace();
            }
            return stringBuilder.toString();
        }

        private String bufferedWriterDataFN(HashMap<String, String> HashMapParams) throws UnsupportedEncodingException {
            StringBuilder stringBuilderObject;
            stringBuilderObject = new StringBuilder();

            for (Map.Entry<String, String> KEY : HashMapParams.entrySet()) {
                if (check)
                    check = false;
                else
                    stringBuilderObject.append("&");
                stringBuilderObject.append(URLEncoder.encode(KEY.getKey(), "UTF-8"));
                stringBuilderObject.append("=");
                stringBuilderObject.append(URLEncoder.encode(KEY.getValue(), "UTF-8"));
            }
            return stringBuilderObject.toString();
        }

    }
	
}
