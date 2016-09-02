<?php
/**
 * TestRelativeTime.php
 *
 * @package Tests
 * @author Michael Pratt <pratt@hablarmierda.net>
 * @link   http://www.michael-pratt.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class TestRelativeTime extends PHPUnit_Framework_TestCase
{
    public function testDateConversion()
    {
        $rt = new \RelativeTime\RelativeTime();
        $result = $rt->convert('2010-09-05', '2010-03-30');
        $this->assertEquals($result, '5 months, 6 days ago');

        $result = $rt->convert('2012-03-05', '2013/02/05');
        $this->assertEquals($result, '11 months left');

        $result = $rt->convert('2010-09-05', '2010/10/05');
        $this->assertEquals($result, '1 month left');

        $result = $rt->convert('2014-09-05', '2010-09-07');
        $this->assertEquals($result, '3 years, 11 months, 28 days ago');

        $result = $rt->convert('2010-09-05', '2010-03-30');
        $this->assertEquals($result, '5 months, 6 days ago');

        $result = $rt->convert('2013-06', '2013-8');
        $this->assertEquals($result, '2 months left');

        $result = $rt->convert('2014-10', '2014-05');
        $this->assertEquals($result, '5 months ago');

        $result = $rt->convert('2018-10', '2013-10');
        $this->assertEquals($result, '5 years ago');

        $result = $rt->convert('2013-05-05', '2013-09-22');
        $this->assertEquals($result, '4 months, 17 days left');

        $result = $rt->convert('2010-09-30', '2010-03-28');
        $this->assertEquals($result, '6 months, 2 days ago');

        $result = $rt->convert('2013-09-20', '2013/09/22');
        $this->assertEquals($result, '2 days left');

        $result = $rt->convert('2010-02-05', '2010/02/04');
        $this->assertEquals($result, '1 day ago');

        // Stamp 1379455200 = 2013-09-17 17:00:00
        // Stamp 1382047200 = 2013-10-17 17:00:00
        $result = $rt->convert(1379455200, 1382047200);
        $this->assertEquals($result, '1 month left');
    }

    public function testTimeConversion()
    {
        $rt = new \RelativeTime\RelativeTime();
        $result = $rt->convert('10:05:00', '10:06:00');
        $this->assertEquals($result, '1 minute left');

        $result = $rt->convert('17:00:01', '6:05:30');
        $this->assertEquals($result, '10 hours, 54 minutes, 31 seconds ago');

        $result = $rt->convert('17:00:01', '17:00:30');
        $this->assertEquals($result, '29 seconds left');

        $result = $rt->convert('17:00:01', '17:00:00');
        $this->assertEquals($result, '1 second ago');

        $result = $rt->convert('17:00', '12:00');
        $this->assertEquals($result, '5 hours ago');

        $result = $rt->convert('17:00', '12:43');
        $this->assertEquals($result, '4 hours, 17 minutes ago');

        $result = $rt->convert('17:05', '17:08');
        $this->assertEquals($result, '3 minutes left');
    }

    public function testDateTimeConversion()
    {
        $rt = new \RelativeTime\RelativeTime();
        $result = $rt->convert('2013-09-25 07:35:02', '2010-08-25 16:22:59');
        $this->assertEquals($result, '3 years, 30 days, 15 hours, 12 minutes, 3 seconds ago');

        $result = $rt->convert('2013-08-25 16:35:02', '2010-08-25 16:22:59');
        $this->assertEquals($result, '3 years, 12 minutes, 3 seconds ago');
    }

    public function testInvalidDate()
    {
        $this->setExpectedException('Exception');

        $rt = new \RelativeTime\RelativeTime();
        $result = $rt->convert('10 05 00', '10 06 00');
        $this->assertEquals($result, '1 minute left');
    }

    public function testTimeAgo()
    {
        $rt = new \RelativeTime\RelativeTime();
        $time = strtotime('-2 days');
        $result = $rt->timeAgo($time);
        $this->assertEquals($result, '2 days ago');

        $time = strtotime('+2 days');
        $result = $rt->timeAgo($time);
        $this->assertEquals($result, 'just now');
    }

    public function testTimeLeft()
    {
        $rt = new \RelativeTime\RelativeTime();
        $time = strtotime('+2 days');
        $result = $rt->timeLeft($time);
        $this->assertEquals($result, '2 days left');

        $time = strtotime('-2 days');
        $result = $rt->timeLeft($time);
        $this->assertEquals($result, 'just now');
    }

    public function testNow()
    {
        $rt = new \RelativeTime\RelativeTime(); $time = time();
        $result = $rt->convert($time, $time);
        $this->assertEquals($result, 'just now');
    }

    public function testTruncate()
    {
        $rt = new \RelativeTime\RelativeTime();
        $result = $rt->convert('2013-03-25 07:35:02', '2010-08-25 16:22:59');
        $this->assertEquals($result, '2 years, 6 months, 30 days, 15 hours, 12 minutes, 3 seconds ago');

        $rt = new \RelativeTime\RelativeTime(array('truncate' => 10));
        $result = $rt->convert('2013-03-25 07:35:02', '2010-08-25 16:22:59');
        $this->assertEquals($result, '2 years, 6 months, 30 days, 15 hours, 12 minutes, 3 seconds ago');

        $rt = new \RelativeTime\RelativeTime(array('truncate' => 5));
        $result = $rt->convert('2013-03-25 07:35:02', '2010-08-25 16:22:59');
        $this->assertEquals($result, '2 years, 6 months, 30 days, 15 hours, 12 minutes ago');

        $rt = new \RelativeTime\RelativeTime(array('truncate' => 4));
        $result = $rt->convert('2013-03-25 07:35:02', '2010-08-25 16:22:59');
        $this->assertEquals($result, '2 years, 6 months, 30 days, 15 hours ago');

        $rt = new \RelativeTime\RelativeTime(array('truncate' => 3));
        $result = $rt->convert('2013-03-25 07:35:02', '2010-08-25 16:22:59');
        $this->assertEquals($result, '2 years, 6 months, 30 days ago');

        $rt = new \RelativeTime\RelativeTime(array('truncate' => 2));
        $result = $rt->convert('2013-03-25 07:35:02', '2010-08-25 16:22:59');
        $this->assertEquals($result, '2 years, 6 months ago');

        $rt = new \RelativeTime\RelativeTime(array('truncate' => 1));
        $result = $rt->convert('2013-03-25 07:35:02', '2010-08-25 16:22:59');
        $this->assertEquals($result, '2 years ago');

        $rt = new \RelativeTime\RelativeTime(array('truncate' => 0));
        $result = $rt->convert('2013-03-25 07:35:02', '2010-08-25 16:22:59');
        $this->assertEquals($result, '2 years, 6 months, 30 days, 15 hours, 12 minutes, 3 seconds ago');

        $rt = new \RelativeTime\RelativeTime(array('truncate' => -1));
        $result = $rt->convert('2013-03-25 07:35:02', '2010-08-25 16:22:59');
        $this->assertEquals($result, '2 years, 6 months, 30 days, 15 hours, 12 minutes, 3 seconds ago');
    }
}

?>
