package com.shop.gudang;

import java.util.ArrayList;
import java.util.List;

import android.annotation.SuppressLint;
import android.os.Bundle;
import android.app.Activity;
import android.app.Fragment;
import android.app.FragmentManager;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.res.Configuration;
import android.content.res.TypedArray;
import android.support.v4.app.ActionBarDrawerToggle;
import android.support.v4.widget.DrawerLayout;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import com.shop.gudang.slidelist.KonfirmasiNotaBeli;
import com.shop.gudang.slidelist.KonfirmasiReturBeli;
import com.shop.gudang.slidelist.KonfirmasiNotaJual;
import com.shop.gudang.slidelist.KonfirmasiReturJual;
import com.shop.gudang.slidelist.BatalKirim;
import com.shop.gudang.slidelist.MutasiGudangMobil;
import com.shop.gudang.slidelist.MutasiMobilGudang;
import com.shop.gudang.slidelist.Pesan;
import com.shop.gudang.slidelist.StockOpname;

public class MainActivity extends Activity {

	Menu menus;
	String[] menutitles;
	TypedArray menuIcons;
	
	// nav drawer title
	private CharSequence mDrawerTitle;
	private CharSequence mTitle;

	private DrawerLayout mDrawerLayout;
	private ListView mDrawerList;
	private ActionBarDrawerToggle mDrawerToggle;

	private List<RowItem> rowItems;
	private CustomAdapter adapter;
	
	@SuppressLint("NewApi")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
     	setContentView(R.layout.activity_main);
		
		mTitle = mDrawerTitle = getTitle();

		menutitles = getResources().getStringArray(R.array.titles);
		menuIcons = getResources().obtainTypedArray(R.array.icons);

		mDrawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
		mDrawerList = (ListView) findViewById(R.id.slider_list);

		rowItems = new ArrayList<RowItem>();

		for (int i = 0; i < menutitles.length; i++) {
			RowItem items = new RowItem(menutitles[i], menuIcons.getResourceId(i,-1));
			rowItems.add(items);
		}

		menuIcons.recycle();

		adapter = new CustomAdapter(getApplicationContext(), rowItems);

		mDrawerList.setAdapter(adapter);
		mDrawerList.setOnItemClickListener(new SlideitemListener());

		// enabling action bar app icon and behaving it as toggle button
		getActionBar().setDisplayHomeAsUpEnabled(true);
		getActionBar().setHomeButtonEnabled(true);

		mDrawerToggle = new ActionBarDrawerToggle(this, mDrawerLayout,
				R.drawable.ic_drawer, // nav menu toggle icon
				R.string.app_name, // nav drawer open - description for
									// accessibility
				R.string.app_name // nav drawer close - description for
									// accessibility
		) {
			public void onDrawerClosed(View view) {
				getActionBar().setTitle(mTitle);
				// calling onPrepareOptionsMenu() to show action bar icons
				invalidateOptionsMenu();
			}

			public void onDrawerOpened(View drawerView) {
				getActionBar().setTitle(mDrawerTitle);
				// calling onPrepareOptionsMenu() to hide action bar icons
				invalidateOptionsMenu();
			}
		};
		mDrawerLayout.setDrawerListener(mDrawerToggle);

		if (savedInstanceState == null) {
			// on first time display view for first nav item
			updateDisplay(0);
		}
	}
	
	class SlideitemListener implements ListView.OnItemClickListener {
		@Override
		public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
			updateDisplay(position);
		}

	}

	private void updateDisplay(int position) {
		Fragment fragment = null;
		switch (position) {
		case 0:
			fragment = new KonfirmasiNotaBeli();
			break;
		case 1:
			fragment = new KonfirmasiReturBeli();
			break;
		case 2:
			fragment = new KonfirmasiNotaJual();
			break;
		case 3:
			fragment = new KonfirmasiReturJual();
			break;
		case 4:
			fragment = new BatalKirim();
			break;
		case 5:
			fragment = new MutasiGudangMobil();
			break;
		case 6:
			fragment = new MutasiMobilGudang();
			break;
		case 7:
			fragment = new StockOpname();
			break;
		case 8:
			fragment = new Pesan();
			break;
		default:
			break;
		}

		if (fragment != null) {
			FragmentManager fragmentManager = getFragmentManager();
			fragmentManager.beginTransaction()
					.replace(R.id.frame_container, fragment).commit();

			// update selected item and title, then close the drawer
			// setTitle(menutitles[position]);
			mDrawerLayout.closeDrawer(mDrawerList);
		}

	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.menu, menu);
		this.menus = menu;
		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		// toggle nav drawer on selecting action bar app icon/title
		if (mDrawerToggle.onOptionsItemSelected(item)) {
			return true;
		}
		// Handle action bar actions click
		switch (item.getItemId()) {
			case R.id.pesan:
				updateDisplay(8);
				break;
			case R.id.exit:
		       CreateExitDialog();
			   break;
		}
		return super.onOptionsItemSelected(item);
	}
	
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data){
		if (resultCode==RESULT_OK && data!= null && data.getData()!= null) {
			Fragment fragment = getFragmentManager().findFragmentById(R.id.frame_container);
			fragment.onActivityResult(requestCode, resultCode, data);
		}
	}
	
	/***
	 * Called when invalidateOptionsMenu() is triggered
	 */
	@Override
	public boolean onPrepareOptionsMenu(Menu menu) {
		// if nav drawer is opened, hide the action items
		boolean drawerOpen = mDrawerLayout.isDrawerOpen(mDrawerList);
		menu.findItem(R.id.exit).setVisible(!drawerOpen);
		return super.onPrepareOptionsMenu(menu);
	}

	/**
	 * When using the ActionBarDrawerToggle, you must call it during
	 * onPostCreate() and onConfigurationChanged()...
	 */
	@Override
	protected void onPostCreate(Bundle savedInstanceState) {
		super.onPostCreate(savedInstanceState);
		// Sync the toggle state after onRestoreInstanceState has occurred.
		mDrawerToggle.syncState();
	}

	@Override
	public void onConfigurationChanged(Configuration newConfig) {
		super.onConfigurationChanged(newConfig);
		// Pass any configuration change to the drawer toggls
		mDrawerToggle.onConfigurationChanged(newConfig);
	}
	@Override
	public void onBackPressed() {
		CreateExitDialog();
	}
	
	public void changePesan(int id){
		switch (id) {
			case 0:
				menus.findItem(R.id.pesan).setIcon(R.drawable.ic_pesan);
				break;
			case 1:
				menus.findItem(R.id.pesan).setIcon(R.drawable.ic_launcher);
				break;
		}
	}
	private void CreateExitDialog() {
		AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(this);
		alertDialogBuilder.setTitle("My Gudang");
		alertDialogBuilder
			.setMessage("Anda ingin Keluar Aplikasi?")
			.setCancelable(false)
			.setPositiveButton("Ya",
			new DialogInterface.OnClickListener() {
				public void onClick(DialogInterface dialog,
					int id) {
						finishAffinity();
				}
			})
			.setNegativeButton("Tidak",
			new DialogInterface.OnClickListener() {
				public void onClick(DialogInterface dialog,
									int id) {
					dialog.cancel();
				}
			});
		AlertDialog alertDialog = alertDialogBuilder.create();
		alertDialog.show();
	}
	
}
