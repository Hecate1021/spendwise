<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Goal Reminder</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f5f6fa; font-family: Arial, Helvetica, sans-serif;">

    <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width: 480px; background: #ffffff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">

                    <!-- Logo / Icon -->
                    <tr>
                        <td align="center" style="padding: 40px 20px 20px;">
                            <img src="{{ asset('images/logo/logobg.png') }}" width="60" height="60" alt="Goal Icon" style="display:block;">
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td align="center" style="padding: 10px 30px;">
                            <h2 style="font-size: 22px; color: #222831; margin: 0;">Goal Reminder 🎯</h2>
                        </td>
                    </tr>

                    <!-- Message -->
                    <tr>
                        <td align="center" style="padding: 15px 30px;">
                            <p style="font-size: 15px; color: #555; line-height: 1.6; margin: 0;">
                                Hi <strong>{{ $goal->user }}</strong>,<br><br>
                                This is a reminder that your goal <strong>"{{ $goal->title }}"</strong> is due today ({{ date('F d, Y', strtotime($goal->aim_date)) }}).
                            </p>
                        </td>
                    </tr>

                    <!-- Details Box -->
                    <tr>
                        <td align="center" style="padding: 20px 30px;">
                            <div style="background-color: #f8f9fb; border-radius: 8px; padding: 15px 20px; text-align: left;">
                                <p style="margin: 0; font-size: 14px; color: #444;"><strong>Description:</strong> {{ $goal->description }}</p>
                                <p style="margin: 6px 0 0; font-size: 14px; color: #444;">
                                    <strong>Target Amount:</strong> ₱{{ number_format($goal->target_amount, 2) }}
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- CTA Button -->
                    <tr>
                        <td align="center" style="padding: 30px;">
                            <a href="{{ url('/') }}"
                               style="background-color: #007bff; color: #ffffff; text-decoration: none;
                                      padding: 12px 30px; border-radius: 6px; font-weight: bold;
                                      font-size: 15px; display: inline-block;">
                                Go to Dashboard
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 20px 30px 40px;">
                            <p style="font-size: 12px; color: #999; line-height: 1.5; margin: 0;">
                                You’re receiving this email because you have an active goal in SpendWise.<br>
                                If you didn’t create this goal, please ignore this message.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
