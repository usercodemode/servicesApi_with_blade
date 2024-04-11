<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth; // Assuming user authentication

class SubscriptionController extends Controller
{
    public function subscribe(Request $request, Service $service)
    {
        $user = Auth::user();
        $subscription =
            $subscription = Subscription::where('user_id', $user->id)
            ->where('service_id', $service->id)
            ->where('status', 'active')
            ->first();
        if ($subscription == null) {
            $subscription = new Subscription([
                'user_id' => $user->id,
                'service_id' => $service->id,
                'start_date' => now(), // Subscription start date
                'status' => 'active',
            ]);

            $subscription->save();

            $service = $subscription->service;
        } else {
            $subscription = ['subscribed' => true];
        }

        return response()->json($subscription, Response::HTTP_CREATED);
    }


    public function singleSubscription(Request $request, $id)
    {
        $user = Auth::user();
        // $subscription = $user->subscriptions->active()->first();
        // $subscription = $user->subscriptions->where('id', $id);
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json(['message' => 'No subscription found'], Response::HTTP_NOT_FOUND);
        }

        $service = $subscription->service;

        return response()->json(compact('subscription'), Response::HTTP_OK);
    }

    public function showActiveSubscription(Request $request)
    {
        $user = Auth::user();
        // $subscription = $user->subscriptions->active()->first();
        //$subscription = $user->subscriptions->with('Subscription', 'Service')->where('status', 'active')->get(); 

        $subscription = Subscription::with('service')->where('user_id', $user->id)->where('status', 'active')->get();

        if (!$subscription) {
            return response()->json(['message' => 'No active subscription found'], Response::HTTP_NOT_FOUND);
        }

        //$service = $subscription->service;


        return response()->json($subscription, Response::HTTP_OK);
    }

    public function showUserSubscription(Request $request)
    {
        $user = Auth::user();
        // $subscription = $user->subscriptions->active()->first();
        $subscription = $user->subscriptions;

        if (!$subscription) {
            return response()->json(['message' => 'No subscription found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($subscription, Response::HTTP_OK);
    }


    public function showAllSubscription(Request $request)
    {
        // $user = Auth::user();
        // $subscription = $user->subscriptions->active()->first();
        $subscription = Subscription::all();

        if (!$subscription) {
            return response()->json(['message' => 'No subscription found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($subscription, Response::HTTP_OK);
    }

    // public function cancelSubscription(Request $request)
    // {
    //     $user = Auth::user();
    //     // $subscription = $user->subscriptions->active()->first();
    //     $subscription = $user->subscriptions->where('status', 'active')->first();


    //     if (!$subscription) {
    //         return response()->json(['message' => 'No active subscription found'], Response::HTTP_NOT_FOUND);
    //     }

    //     $subscription->update(['status' => 'cancelled']);

    //     return response()->json(['message' => 'Subscription cancelled successfully'], Response::HTTP_OK);
    // }

    public function cancelSubscription(Request $request, $id)
    {
        $user = Auth::user();
        //$subscription = $user->subscriptions->active()->first();
        $subscription = $user->subscriptions->where('id', $id)->where('status', 'active')->first();

        //return response()->json($subscription, Response::HTTP_OK);
        if (!$subscription) {
            return response()->json(['message' => 'No active subscription found'], Response::HTTP_NOT_FOUND);
        }

        $subscription->update(['status' => 'cancelled']);

        return response()->json(['message' => 'Subscription cancelled successfully'], Response::HTTP_OK);
    }
}
